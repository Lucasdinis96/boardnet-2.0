import { inject, Injectable } from '@angular/core';
import { ApiService } from '../../core/services/api.service';
import { tap } from 'rxjs';


@Injectable({
  providedIn: 'root',
})
export class TradeService {

  private api = inject(ApiService)

  getAll() {
    return this.api.get<any>('trades/getAll')
  }

  getTradeById (id: number) {
    return this.api.show<any>('trades/show', id)
  }

  addCart(data: any){
    return this.api.post<any>('cart/items', data)
  }
}