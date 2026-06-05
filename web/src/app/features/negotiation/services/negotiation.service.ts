import { inject, Injectable } from '@angular/core';
import { ApiService } from '../../../core/services/api.service';

@Injectable({
  providedIn: 'root',
})
export class NegotiationService {

    private api = inject(ApiService)

    getCart () {
      return this.api.get<any>('cart')
    }

    checkout(data: any){
      return this.api.post<any>('checkout', data);
    }

    removeItemFromCart(id: any){
      return this.api.delete<any>('cart/items', id)
    }

    createPayment(method: any, id: any){
      return this.api.post<any>(`negotiations/${id}/payments`, method)
    }

    clearCart() {
      return this.api.delete<any>('cart/clear')
    }
}
