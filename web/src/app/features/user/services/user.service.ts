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
    return this.api.put<any>('user/userUpdate', data, id).pipe(
      tap((response) => {})
    );
  }

  updateAddress(data: any, id: any){
    return this.api.put<any>('user/addressUpdate', data, id).pipe(
      tap((response) => {})
    );
  }

  updatePassword(data: any, id: any){
    return this.api.put<any>('user/passwordUpdate', data, id).pipe(tap((response) => {} ))
  }

  deleteAccount(data: any, id: any, ) {
    return this.api.put<any>('user/deleteAccount', data, id).pipe(tap((response) => {} ))
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

  getPixData() {
    return this.api.get<any>('user/pix')
}

  updatePixData(data: any) {
    return this.api.put<any>('user/pix/update', data)
  }

  getWithdrawals(page: number = 1) {
    return this.api.getPaginated<any>('user/withdrawals', {page});
  }

  requestWithdrawal(id: number) {
    return this.api.post(`user/withdrawals/${id}/request`,{});
}

}
