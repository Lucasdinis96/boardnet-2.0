import { inject, Injectable } from '@angular/core';
import { ApiService } from '../../core/services/api.service';

@Injectable({
  providedIn: 'root',
})
export class HomeService {

  private api = inject(ApiService);

  getHomeGames (){
    return this.api.get<any>('home/games');
  }

  getHomeTrades (){
    return this.api.get<any>('home/trades');
  }

}
