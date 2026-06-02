import { Component, inject } from '@angular/core';
import { NegotiationStateService } from '../../services/negotiation-state.service';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-payment',
  imports: [CommonModule],
  templateUrl: './payment.component.html',
  styleUrl: './payment.component.scss',
})
export class PaymentComponent {

  private stateService = inject(NegotiationStateService)

  payment = this.stateService.payment;

}
