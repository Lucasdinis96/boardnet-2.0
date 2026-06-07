import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from '../../../environments/environment';
import { map } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class ApiService {

  constructor (private http: HttpClient){}

  private apiUrl = environment.apiUrl;

  get<T>(endpoint: string, params?: Record<string, any>){
    return this.http.get<{data: T}>(`${this.apiUrl}/${endpoint}`, { params }).pipe(map(response => response.data));
  }

  show<T>(endpoint: string, id: number){
    return this.http.get<{data: T}>(`${this.apiUrl}/${endpoint}/${id}`).pipe(map(response => response.data));
  }

  post<T>(endpoint: string, data: any){
    return this.http.post<{data: T}>(`${this.apiUrl}/${endpoint}`, data).pipe(map(response => response.data));
  }

  put<T>(endpoint: string, id: string, data: any) {
    return this.http.put<{data: T}>(`${this.apiUrl}/${endpoint}/${id}`, data).pipe(map(response =>response.data));
  }

  delete<T>(endpoint: string, id?: string) {
    const url = id ? `${this.apiUrl}/${endpoint}/${id}`: `${this.apiUrl}/${endpoint}`
    return this.http.delete<{data: T}>(url).pipe(map(response => response.data));
  }

}
