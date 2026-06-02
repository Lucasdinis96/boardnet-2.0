import { Component, inject } from '@angular/core';
import { ActivatedRoute, RouterLink } from '@angular/router';
import { CommonModule } from '@angular/common';
import { BehaviorSubject, catchError, combineLatest, map, Observable, of, switchMap, tap } from 'rxjs';
import { TradeService } from '../../trade.service';
import { FlashMessageService } from '../../../../core/services/flash-message.service';

@Component({
  selector: 'app-trade-detail',
  imports: [CommonModule, RouterLink],
  templateUrl: './trade-detail.component.html',
  styleUrl: './trade-detail.component.scss',
})
export class TradeDetailComponent {

  private route = inject(ActivatedRoute);
  private service = inject(TradeService);
  private flashMessage = inject(FlashMessageService);
  trade$!: Observable<any>
  message: any

  
  ngOnInit() {
    this.trade$ = this.route.paramMap.pipe(
      map(params => Number(params.get('id'))),
      switchMap(id => this.service.getTradeById(id))
    );
  }

  addCart(tradeItemId: number) {
    const payload = {
      trade_item_id: tradeItemId
    }
    this.service.addCart(payload).subscribe({
      next: (response) => {this.flashMessage.success(response.message)},
      error: (response) => {this.flashMessage.warning(response.error.message)}
    })
  }
}
