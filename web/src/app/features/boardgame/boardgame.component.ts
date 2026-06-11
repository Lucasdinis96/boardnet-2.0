import { Component, inject } from '@angular/core';
import { BoardgameService } from './boardgame.service';
import { CommonModule } from '@angular/common';
import { RouterLink } from '@angular/router';
import { FormControl, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { map, Observable, tap } from 'rxjs';
import { PaginationComponent } from '../../shared/components/pagination/pagination.component';

@Component({
  selector: 'app-boardgame',
  imports: [CommonModule, RouterLink, ReactiveFormsModule, PaginationComponent],
  templateUrl: './boardgame.component.html',
  styleUrl: './boardgame.component.scss',
})
export class BoardgameComponent {
  private boardgameService = inject(BoardgameService);
  filterForm!: FormGroup
  pagination = {
    currentPage: 1,
    lastPage: 1,
    perPage: 0,
    total: 0
  };

  $boardgames!: Observable<any[]>;

  ngOnInit() {
    this.initializeForm()
    this.loadPage()
  }

  initializeForm() {
    this.filterForm = new FormGroup<any>({
      game_name: new FormControl(null),
      min_players: new FormControl(null),
      max_players: new FormControl(null),
      age_range: new FormControl(null)
    })
  }

  submit(){
    this.loadPage(1)
  }

  getPlayersCount(boardgame: any): string {
    const min = boardgame.min_players;
    const max = boardgame.max_players;

    if (!max || min === max) {
      return `${min} jogadores`;
    }
    return `De ${min} a ${max} jogadores`;
  }

  clearFilters() {
    this.filterForm.reset()
    this.loadPage(1)
  }

  loadPage(page: number = 1) {
      const filters = this.getFilters();
      this.$boardgames = this.boardgameService.getAll(page, filters).pipe(
        tap(response => {this.pagination = {
          currentPage: response.meta.current_page,
          lastPage: response.meta.last_page,
          perPage: response.meta.per_page,
          total: response.meta.total
        };}),
        map(response => this.prepareGames(response.data))
      );
    }
  
  private getFilters() {
    return Object.fromEntries(
      Object.entries(this.filterForm.value)
        .filter(([_, value]) => value !== null && value !== '')
    );
  }

  private prepareGames(games: any[]) {
    return games.map(game => ({
      ...game,
      primaryImage:
        game.images?.find((image: any) => image.is_primary)?.path ?? null
    }));
  }
}
