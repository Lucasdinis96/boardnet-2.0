import { inject, Injectable } from '@angular/core';
import { ApiService } from '../../core/services/api.service';
import { tap } from 'rxjs';
import { BoardgameIndex } from './models/boardgameIndex';
import { BoardgameDetail } from './models/boardgameDetail';

@Injectable({
  providedIn: 'root',
})
export class BoardgameService {

  private api = inject(ApiService)

  getAll() {
    return this.api.get<any>('boardgames')
  }

  getBoardgameById (id: number) {
    return this.api.show<BoardgameDetail>('boardgames', id)
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

  checkCollection(userId: number, boardgameId: number) {
    return this.api.get(`checkCollection/${userId}/${boardgameId}`)
  }

}
