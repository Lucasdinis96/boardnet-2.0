import { Component, inject } from '@angular/core';
import { UserService } from '../../services/user.service';
import { Router, RouterLink, RouterModule } from '@angular/router';
import { CommonModule } from '@angular/common';
import { TradeImagesUrlPipe } from '../../../../shared/pipes/trade-images-url-pipe';
import { map, Observable, tap } from 'rxjs';
import { PaginationComponent } from '../../../../shared/components/pagination/pagination.component';

@Component({
  selector: 'app-user-trades',
  imports: [CommonModule, RouterLink, RouterModule, TradeImagesUrlPipe, PaginationComponent],
  templateUrl: './user-trades.component.html',
  styleUrl: './user-trades.component.scss',
})
export class UserTradesComponent {

  private userService = inject(UserService);
  id: any = localStorage.getItem('id');
  selectedTradeId: number | null = null;
  isEditRoute = false
  showEditModal = false;
  $trades!: Observable<any[]>
  pagination = {
    currentPage: 1,
    lastPage: 1,
    perPage: 0,
    total: 0
  };
  
  constructor(private router: Router) {
    this.router.events.subscribe(() => {this.isEditRoute = this.router.url.includes('/edit');});
  }

  ngOnInit() {
    this.loadPage()
  }

  private prepareTrades(trades: any[]) {
      return trades.map(trade => ({
        ...trade,
        primaryImage:
          trade.images?.find(
            (image: any) => image.is_primary
          )?.path ?? null
      }));
    }
  
    loadPage(page: number = 1) {
      this.$trades = this.userService.getTrades(page, this.id).pipe(
        tap(response => {this.pagination = {
          currentPage: response.meta.current_page,
          lastPage: response.meta.last_page,
          perPage: response.meta.per_page,
          total: response.meta.total
        };}),
        map(response => this.prepareTrades(response.data))
      );
    }

  removeTrade(id: any) {
    this.userService.removeTrade(id).subscribe((response) => {})
  }
  
}
