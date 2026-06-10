import { Component, inject } from '@angular/core';
import { ActivatedRoute, RouterLink } from '@angular/router';
import { CommonModule } from '@angular/common';
import { BehaviorSubject, catchError, combineLatest, map, Observable, of, switchMap, tap } from 'rxjs';
import { TradeService } from '../../trade.service';
import { FlashMessageService } from '../../../../core/services/flash-message.service';
import { TradeImagesUrlPipe } from '../../../../shared/pipes/trade-images-url-pipe';

@Component({
  selector: 'app-trade-detail',
  imports: [CommonModule, RouterLink, TradeImagesUrlPipe],
  templateUrl: './trade-detail.component.html',
  styleUrl: './trade-detail.component.scss',
})
export class TradeDetailComponent {

  private route = inject(ActivatedRoute);
  private service = inject(TradeService);
  private flashMessage = inject(FlashMessageService);
  trade$!: Observable<any>
  message: any
  selectedImage: string | null = null;


  
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

  getPrimaryImage(trade: any): string {

    const primary = trade.images?.find(
      (image: any) => image.is_primary
    );

    if (!primary) {
      return 'assets/photoicon.png';
    }

    return primary.path;
  }

  openImage(path: string): void {
    this.selectedImage = path;
  }

  closeImage(): void {
    this.selectedImage = null;
  }
}
