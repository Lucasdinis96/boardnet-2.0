import { Component, inject } from '@angular/core';
import { UserService } from '../../user.service';
import { Router, RouterLink, RouterModule } from '@angular/router';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-user-trades',
  imports: [CommonModule, RouterLink, RouterModule],
  templateUrl: './user-trades.component.html',
  styleUrl: './user-trades.component.scss',
})
export class UserTradesComponent {

  private userService = inject(UserService);
  id: any = localStorage.getItem('id');
  $trades = this.userService.getTrades(this.id);
  selectedTradeId: number | null = null;
  isEditRoute = false
  showEditModal = false;
  
  constructor(private router: Router) {
    this.router.events.subscribe(() => {this.isEditRoute = this.router.url.includes('/edit');});
  }

  removeTrade(id: any) {
    this.userService.removeTrade(id).subscribe((response) => {})
  }
  
}
