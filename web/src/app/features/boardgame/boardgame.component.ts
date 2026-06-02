import { Component, inject } from '@angular/core';
import { BoardgameService } from './boardgame.service';
import { CommonModule } from '@angular/common';
import { RouterLink } from '@angular/router';

@Component({
  selector: 'app-boardgame',
  imports: [CommonModule, RouterLink],
  templateUrl: './boardgame.component.html',
  styleUrl: './boardgame.component.scss',
})
export class BoardgameComponent {
  private boardgameService = inject(BoardgameService);

  $boardgames = this.boardgameService.getAll();

  getPlayersCount(boardgame: any): string {
    const min = boardgame.min_players;
    const max = boardgame.max_players;

    if (!min || min === max) {
      return `${max} jogadores`;
    }
    return `De ${min} a ${max} jogadores`;
  }

}
