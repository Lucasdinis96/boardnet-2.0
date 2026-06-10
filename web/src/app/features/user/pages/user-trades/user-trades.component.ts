import { Component, inject } from '@angular/core';
import { UserService } from '../../services/user.service';
import { Router, RouterLink, RouterModule } from '@angular/router';
import { CommonModule } from '@angular/common';
import { TradeImagesUrlPipe } from '../../../../shared/pipes/trade-images-url-pipe';
import { map } from 'rxjs';

@Component({
  selector: 'app-user-trades',
  imports: [CommonModule, RouterLink, RouterModule, TradeImagesUrlPipe],
  templateUrl: './user-trades.component.html',
  styleUrl: './user-trades.component.scss',
})
export class UserTradesComponent {

  private userService = inject(UserService);
  id: any = localStorage.getItem('id');
  selectedTradeId: number | null = null;
  isEditRoute = false
  showEditModal = false;
$trades = this.userService.getTrades(this.id).pipe(
  map(trades =>
    trades.map((trade: any) => ({
      ...trade,
      primaryImage:
        trade.images?.find(
          (image: any) => image.is_primary
        )?.path ?? null
    }))
  )
);
  
  constructor(private router: Router) {
    this.router.events.subscribe(() => {this.isEditRoute = this.router.url.includes('/edit');});
  }

  removeTrade(id: any) {
    this.userService.removeTrade(id).subscribe((response) => {})
  }
  
}
