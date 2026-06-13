import { Component, inject } from '@angular/core';
import { TradeService } from './trade.service';
import { CommonModule } from '@angular/common';
import { RouterLink } from '@angular/router';
import { FormControl, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { map, Observable, tap } from 'rxjs';
import { TradeImagesUrlPipe } from '../../shared/pipes/trade-images-url-pipe';
import { PaginationComponent } from '../../shared/components/pagination/pagination.component';

@Component({
  selector: 'app-trade',
  imports: [CommonModule, RouterLink, ReactiveFormsModule, TradeImagesUrlPipe, PaginationComponent],
  templateUrl: './trade.component.html',
  styleUrl: './trade.component.scss',
})
export class TradeComponent {
  private tradeService = inject(TradeService);
  filterForm!: FormGroup
  pagination = {
    currentPage: 1,
    lastPage: 1,
    perPage: 0,
    total: 0
  };

  $trades!: Observable<any[]>

  ngOnInit() {
    this.initializeForm()
    this.loadPage()
  }

  initializeForm() {
    this.filterForm = new FormGroup<any>({
      game_name: new FormControl(null),
      seller: new FormControl(null),
      min_value: new FormControl(null),
      max_value: new FormControl(null),
    })
  }

  submit(){
    this.loadPage(1)
  }

  clearFilters() {
    this.filterForm.reset()
    this.loadPage(1)
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
    const filters = this.getFilters();
    this.$trades = this.tradeService.getAll(page, filters).pipe(
      tap(response => {this.pagination = {
        currentPage: response.meta.current_page,
        lastPage: response.meta.last_page,
        perPage: response.meta.per_page,
        total: response.meta.total
      };}),
      map(response => this.prepareTrades(response.data))
    );
  }

  private getFilters() {
    return Object.fromEntries(
      Object.entries(this.filterForm.value)
        .filter(([_, value]) => value !== null && value !== '')
    );
  }

  hasActiveFilters(): boolean {
  return Object.values(this.filterForm.value)
    .some(value => value !== null && value !== '');
  }

}
