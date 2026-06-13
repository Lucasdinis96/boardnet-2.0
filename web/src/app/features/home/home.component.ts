import { CommonModule } from '@angular/common';
import { Component, inject } from '@angular/core';
import { RouterLink } from '@angular/router';
import { HomeService } from './home.service';

@Component({
  selector: 'app-home',
  imports: [CommonModule, RouterLink],
  templateUrl: './home.component.html',
  styleUrl: './home.component.scss',
})
export class HomeComponent {

  private homeService = inject(HomeService)
  $boardgames = this.homeService.getHomeGames();
  $trades = this.homeService.getHomeTrades();


}
