import { Component, inject } from '@angular/core';
import { ActivatedRoute, RouterLink } from '@angular/router';
import { BoardgameService } from '../../boardgame.service';
import { CommonModule } from '@angular/common';
import { BehaviorSubject, catchError, combineLatest, map, Observable, of, switchMap, tap } from 'rxjs';
import { FlashMessageService } from '../../../../core/services/flash-message.service';
import { PaginationComponent } from '../../../../shared/components/pagination/pagination.component';

@Component({
  selector: 'app-boardgame-detail',
  imports: [CommonModule, RouterLink, PaginationComponent],
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
  currentPage = 1;
  pagination = {
    currentPage: 1,
    lastPage: 1,
    perPage: 0,
    total: 0
} ;

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
    this.loadPage();
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

  getPlayersCount(boardgame: any): string {
    const min = boardgame.min_players;
    const max = boardgame.max_players;

    if (!max || min === max) {
      return `${min} jogadores`;
    }
    return `De ${min} a ${max} jogadores`;
  }

  loadPage(page: number = 1) {
  this.currentPage = page;

  const boardgameId = Number(
    this.route.snapshot.paramMap.get('id')
  );

  this.boardgame$ = this.refresh$.pipe(
    switchMap(() =>
      this.service.getBoardgameById(
        boardgameId,
        this.currentPage
      )
    ),
    tap(response => {this.pagination = {
        currentPage: response.trades.meta.current_page,
        lastPage: response.trades.meta.last_page,
        perPage: response.trades.meta.per_page,
        total: response.trades.meta.total
      };}),
  );
}

  
}
