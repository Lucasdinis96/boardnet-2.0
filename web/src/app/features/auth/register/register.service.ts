import { inject, Injectable } from '@angular/core';
import { ApiService } from '../../../core/services/api.service';
import { tap } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class RegisterService {
  private api = inject(ApiService);
  registerUser(data: any){
    return this.api.post<any>('auth/register', data).pipe(
      tap((response) => {
        console.log('User Created', response);
      })
    );
  }
}
