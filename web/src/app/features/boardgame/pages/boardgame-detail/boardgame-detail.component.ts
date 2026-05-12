import { Component, inject } from '@angular/core';
import { ActivatedRoute, RouterLink } from '@angular/router';
import { BoardgameService } from '../../boardgame.service';
import { CommonModule } from '@angular/common';
import { BehaviorSubject, catchError, combineLatest, map, Observable, of, switchMap, tap } from 'rxjs';
import { FlashMessageService } from '../../../../core/services/flash-message.service';

@Component({
  selector: 'app-boardgame-detail',
  imports: [CommonModule, RouterLink],
  templateUrl: './boardgame-detail.component.html',
  styleUrl: './boardgame-detail.component.scss',
})
export class BoardgameDetailComponent {

  private route = inject(ActivatedRoute);
  private service = inject(BoardgameService);
  private refresh$ = new BehaviorSubject<void>(undefined);
  private flashMessage = inject(FlashMessageService);
  boardgame$!: Observable<any>
  exist!: string

  exist$ = combineLatest([
    this.route.paramMap,
    this.refresh$
  ]).pipe(
    map(([params]) => Number(params.get('id'))),
    switchMap(id => this.checkCollection(id).pipe(
      catchError(err => {
        if (err.status === 401) {
          return of(null);
        }
        return of(false)
      })
    )
    )
  );
  ngOnInit() {
    this.boardgame$ = this.route.paramMap.pipe(
      map(params => Number(params.get('id'))),
      switchMap(id => this.service.getBoardgameById(id))
    );
  }

  addCollection(boardgameId: number) {
    const userId = localStorage.getItem('id');
    const payload = {
      user_id: userId,
      boardgame_id: boardgameId
    }
    this.service.addCollection(payload).subscribe((response: any) => {
      this.flashMessage.success(response.message);
      this.refresh$.next();
    });
    
  }

  removeCollection(boardgameId: number) {
    const userId = localStorage.getItem('id');
    const payload = {
      user_id: userId,
      boardgame_id: boardgameId
    }
    this.service.removeCollection(payload).subscribe((response: any) => {
      this.flashMessage.success(response.message)
      this.refresh$.next();
    });
    
  }

  checkCollection (boardgameId: number){
    const userId = Number(localStorage.getItem('id'));
    return this.service.checkCollection(userId, boardgameId);
  }
}
