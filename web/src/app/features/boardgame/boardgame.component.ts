import { Component, inject } from '@angular/core';
import { BoardgameService } from './boardgame.service';
import { CommonModule } from '@angular/common';
import { RouterLink } from '@angular/router';
import { FormControl, FormGroup, ReactiveFormsModule } from '@angular/forms';

@Component({
  selector: 'app-boardgame',
  imports: [CommonModule, RouterLink, ReactiveFormsModule],
  templateUrl: './boardgame.component.html',
  styleUrl: './boardgame.component.scss',
})
export class BoardgameComponent {
  private boardgameService = inject(BoardgameService);
  filterForm!: FormGroup

  $boardgames = this.boardgameService.getAll();

  ngOnInit() {
    this.initializeForm()
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
    this.filterTrades()
  }

  filterTrades() {
    const filters = Object.fromEntries(Object.entries(this.filterForm.value).filter(([_, value]) => value !== null && value !== ''))
    this.$boardgames = this.boardgameService.filterGame(filters);
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
    this.$boardgames
  }

}
