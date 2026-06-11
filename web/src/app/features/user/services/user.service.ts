import { inject, Injectable } from '@angular/core';
import { ApiService } from '../../../core/services/api.service';
import { tap } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class UserService {
  private api = inject(ApiService);

  getUser(id: any){
    return this.api.show<any>('user/me', id);
  }

  getAddress(id: any){
    return this.api.show<any>('user/address', id);
  }

  updateUser(data: any, id: any){
    return this.api.put<any>('user/userUpdate', id, data).pipe(
      tap((response) => {})
    );
  }

  updateAddress(data: any, id: any){
    return this.api.put<any>('user/addressUpdate', id, data).pipe(
      tap((response) => {})
    );
  }

  updatePassword(data: any, id: any){
    return this.api.put<any>('user/passwordUpdate', id, data).pipe(tap((response) => {} ))
  }

  deleteAccount(data: any, id: any, ) {
    return this.api.put<any>('user/deleteAccount', id, data).pipe(tap((response) => {} ))
  }

  getCollection (page: number = 1, id: any) {
    return this.api.getPaginated<any>(`user/collection/${id}`, {page});
  }

  removeFromCollection(id: any) {
    return this.api.delete<any>('user/removeFromCollection', id);
  }

  getTrades (page: number = 1, id: any) {
    return this.api.getPaginated<any>(`user/trades/${id}`, {page});
  }
  
  getTradeById (id: any) {
    return this.api.show<any>('user/trades/show', id);
  }

  createTrade (data: any) {
    return this.api.post<any>('user/trades/create', data,);
  }

  updateTrade (data: any, id: any) {
    return this.api.post<any>(`user/trades/update/${id}`, data,);
  }

  removeTrade (id: any) {
    return this.api.delete<any>('user/trades/delete', id);
  }

  getAllNegotiation(){
    return this.api.get<any>('negotiations');
  }

  getNegotiationAsBuyer(page: number = 1){
    return this.api.getPaginated<any>('negotiations/buyer', {page});
  }

  getNegotiationAsSeller(page: number = 1){
    return this.api.getPaginated<any>('negotiations/seller', {page});
  }

  confirmShipping(data: any, id: any) {
    return this.api.post<any>(`negotiations/${id}/shipped`, data);
  }

  confirmReceivement(data: any) {
    return this.api.post<any>('negotiations/delivered', data)
  }

  updateAvatar(file: File) {
    const formData = new FormData()
    formData.append('image', file)
    return this.api.post<any>('user/avatar', formData);
  }

}
