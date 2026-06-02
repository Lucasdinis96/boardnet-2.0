import { CommonModule } from '@angular/common';
import { Component, inject } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { NegotiationService } from '../../services/negotiation.service';
import { FlashMessageService } from '../../../../core/services/flash-message.service';
import { ActivatedRoute, Router } from '@angular/router';
import { NegotiationStateService } from '../../services/negotiation-state.service';

@Component({
  selector: 'app-checkout',
  imports: [CommonModule, FormsModule],
  templateUrl: './checkout.component.html',
  styleUrl: './checkout.component.scss',
})
export class CheckoutComponent {

  private negotiationService = inject(NegotiationService)
  private stateService = inject(NegotiationStateService)
  private flashMessage = inject(FlashMessageService)
  private route = inject(ActivatedRoute)
  private router = inject(Router)
  paymentMethods = [
    {id: 1, method: 'PIX', nome: 'Pix'},
    {id: 2, method: 'CARD', nome: 'Cartão de Crédito'}
  ]
  selectedMethod: any
  id: any
  negotiation = this.stateService.negotiation;
  
  createPayment(method:any){
    const negotiationId = this.negotiation()?.id;
    console.log(negotiationId);
    const payload = {
      payment_method: method
    }

    this.negotiationService.createPayment(payload, negotiationId).subscribe({
      next:(response) => {
        this.flashMessage.success(response.message),
        this.stateService.setPayment(response.payment)
        this.router.navigate(['negotiation/payment'])
      },
      error:() => {this.flashMessage.warning('Erro ao criar o checkout')}
    })
  }

}
