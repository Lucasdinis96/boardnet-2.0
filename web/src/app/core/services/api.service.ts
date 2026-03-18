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

  get<T>(endpoint: string){
    return this.http.get<T>(`${this.apiUrl}/${endpoint}`);
  }

  show<T>(endpoint: string, id: string){
    return this.http.get<T>(`${this.apiUrl}/${endpoint}/${id}`);
  }

  post<T>(endpoint: string, data: any){
    return this.http.post<{data: T}>(`${this.apiUrl}/${endpoint}`, data).pipe(map(response => response.data));
  }

  put<T>(endpoint: string, id: string, data: any) {
    return this.http.put<{data: T}>(`${this.apiUrl}/${endpoint}/${id}`, data).pipe(map(response =>response.data));
  }

  delete<T>(endpoint: string, id: string) {
    return this.http.delete<T>(`${this.apiUrl}/${endpoint}/${id}`);
  }

}
