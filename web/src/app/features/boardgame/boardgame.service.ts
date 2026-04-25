import { inject, Injectable } from '@angular/core';
import { ApiService } from '../../core/services/api.service';
import { tap } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class BoardgameService {

  private api = inject(ApiService)

  getAll() {
    return this.api.get<any>('boardgames')
  }

  getBoardgameById (id: any) {
    return this.api.show<any>('boardgames', id)
  }

  addCollection(data: any){
    return this.api.post('addCollection', data).pipe(
          tap((response) => {})
    );
  }

  removeCollection(data: any){
    return this.api.post('removeCollection', data).pipe(
          tap((response) => {})
    );
  }

  checkCollection(userId: any, boardgameId: any) {
    return this.api.get(`checkCollection/${userId}/${boardgameId}`)
  }

}
