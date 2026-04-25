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

}
