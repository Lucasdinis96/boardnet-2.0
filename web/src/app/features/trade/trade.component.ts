import { Component, inject } from '@angular/core';
import { TradeService } from './trade.service';
import { CommonModule } from '@angular/common';
import { RouterLink } from '@angular/router';
import { FormControl, FormGroup, ReactiveFormsModule } from '@angular/forms';

@Component({
  selector: 'app-trade',
  imports: [CommonModule, RouterLink, ReactiveFormsModule],
  templateUrl: './trade.component.html',
  styleUrl: './trade.component.scss',
})
export class TradeComponent {
  private tradeService = inject(TradeService);
  filterForm!: FormGroup

  $trades = this.tradeService.getAll();

  ngOnInit() {
    this.initializeForm()
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
    this.filterTrades()
  }

  filterTrades() {
    const filters = Object.fromEntries(Object.entries(this.filterForm.value).filter(([_, value]) => value !== null && value !== ''))
    this.$trades = this.tradeService.filterTrades(filters);
  }

  clearFilters() {
    this.filterForm.reset()
    this.$trades
  }

}
