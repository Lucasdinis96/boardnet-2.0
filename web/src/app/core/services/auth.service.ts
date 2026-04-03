import { inject, Injectable } from '@angular/core';
import { ApiService } from './api.service';
import { BehaviorSubject, tap } from 'rxjs';
import { User } from '../models/user';

@Injectable({
  providedIn: 'root',
})
export class AuthService {

  private api = inject(ApiService);

  private tokenKey= 'token';

  private userSubject = new BehaviorSubject<User| null>(null);
  private isLoggedInSubject = new BehaviorSubject<boolean>(false);
  private readySubject = new BehaviorSubject(false);
  isReady$ = this.readySubject.asObservable();
  isLoggedIn$ = this.isLoggedInSubject.asObservable();
  user$ = this.userSubject.asObservable();

  initSession() {
    const token = this.getToken();

    if (!token) {
      this.readySubject.next(true);
      return;
    }

    this.fetchUser();

    this.readySubject.next(true);
  }

  login(credentials: {email: string; password: string}) {
    return this.api.post<any>('auth/login', credentials).pipe(
      tap((response) => {
        this.setToken(response.token);
        this.userSubject.next(response.user);
        this.isLoggedInSubject.next(true);
      }));
  }

  logout() {
    return this.api.post<void>('auth/logout', {}).pipe(
      tap(() => {
        this.removeToken();
        this.userSubject.next(null);
        this.isLoggedInSubject.next(false);
      }));
  }

  fetchUser() { 
    this.api.get<any>('auth/me').subscribe({
      next: (user) => {
        this.userSubject.next(user);
        this.isLoggedInSubject.next(true);
      },
      error: () => {
        this.userSubject.next(null);
        this.isLoggedInSubject.next(false);
      }
    });
  }

  private setToken(token: string) {
    localStorage.setItem(this.tokenKey, token);
  }

  private getToken() {
    return localStorage.getItem (this.tokenKey);
  }

  public removeToken() {
    localStorage.removeItem(this.tokenKey);
  }

  isAuthenticated(): boolean {
    return !!this.getToken();
  }

}
