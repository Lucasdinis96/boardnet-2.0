import { inject, Injectable } from '@angular/core';
import { ApiService } from '../../core/services/api.service';
import { tap } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class UserService {
  private api = inject(ApiService);

  getUser(id: any){
    return this.api.show<any>('user/me', id);
  }

  getAdress(id: any){
    return this.api.show<any>('user/adress', id);
  }

  updateUser(data: any, id: any){
    return this.api.put<any>('user/userUpdate', id, data).pipe(
      tap((response) => {})
    );
  }

  updateAdress(data: any, id: any){
    return this.api.put<any>('user/adressUpdate', id, data).pipe(
      tap((response) => {})
    );
  }

  updatePassword(data: any, id: any){
    return this.api.put<any>('user/passwordUpdate', id, data).pipe(tap((response) => {} ))
  }

  deleteAccount(data: any, id: any, ) {
    return this.api.put<any>('user/deleteAccount', id, data).pipe(tap((response) => {} ))
  }

  getCollection (id: any) {
    return this.api.get<any>(`user/collection/${id}`);
  }

  removeFromCollection(id: any) {
    return this.api.delete<any>('user/removeFromCollection', id);
  }
}
