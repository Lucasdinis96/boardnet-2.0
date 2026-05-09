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
    return this.api.get<any>('boardgames/getAll')
  }

  getBoardgameById (id: number) {
    return this.api.show<BoardgameDetail>('boardgames/show', id)
  }

  addCollection(data: any){
    return this.api.post('boardgames/addCollection', data).pipe(
          tap((response) => {})
    );
  }

  removeCollection(data: any){
    return this.api.post('boardgames/removeCollection', data).pipe(
          tap((response) => {})
    );
  }

  checkCollection(userId: number, boardgameId: number) {
    return this.api.get(`boardgames/checkCollection/${userId}/${boardgameId}`)
  }

  searchGame (term: any) {
    return this.api.get<any[]>(`boardgames/search?name=${term}`);
  }

}
