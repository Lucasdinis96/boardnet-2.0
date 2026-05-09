import { Component, inject } from '@angular/core';
import { TradeService } from './trade.service';
import { CommonModule } from '@angular/common';
import { RouterLink } from '@angular/router';

@Component({
  selector: 'app-trade',
  imports: [CommonModule, RouterLink],
  templateUrl: './trade.component.html',
  styleUrl: './trade.component.scss',
})
export class TradeComponent {
  private tradeService = inject(TradeService);

  $trades = this.tradeService.getAll();

}
