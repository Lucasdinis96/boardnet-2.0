import { Component, inject } from '@angular/core';
import { ActivatedRoute, RouterLink } from '@angular/router';
import { CommonModule } from '@angular/common';
import { BehaviorSubject, catchError, combineLatest, map, Observable, of, switchMap, tap } from 'rxjs';
import { TradeService } from '../../trade.service';

@Component({
  selector: 'app-trade-detail',
  imports: [CommonModule, RouterLink],
  templateUrl: './trade-detail.component.html',
  styleUrl: './trade-detail.component.scss',
})
export class TradeDetailComponent {

  private route = inject(ActivatedRoute);
  private service = inject(TradeService);
  trade$!: Observable<any>

  
  ngOnInit() {
    this.trade$ = this.route.paramMap.pipe(
      map(params => Number(params.get('id'))),
      switchMap(id => this.service.getTradeById(id))
    );
  }
}
