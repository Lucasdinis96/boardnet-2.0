import { CommonModule } from '@angular/common';
import { Component, inject } from '@angular/core';
import { Router, RouterLink } from '@angular/router';
import { NegotiationService } from '../../services/negotiation.service';
import { AddressFormComponent } from '../../../../shared/components/address-form/address-form.component';
import { FlashMessageService } from '../../../../core/services/flash-message.service';
import { NegotiationStateService } from '../../services/negotiation-state.service';

@Component({
  selector: 'app-cart',
  imports: [CommonModule, RouterLink, AddressFormComponent],
  templateUrl: './cart.component.html',
  styleUrl: './cart.component.scss',
})
export class CartComponent {
  private negotiationService = inject(NegotiationService);
  private stateService = inject(NegotiationStateService);
  private flashMessage = inject(FlashMessageService);
  private router = inject(Router);
  
  cart$ = this.negotiationService.getCart()

  checkout(shipping_address: any){
    this.negotiationService.checkout({shipping_address}).subscribe({
      next:(response) => {
        console.log(response);
        this.flashMessage.success(response.message)
        this.stateService.setNegotiation(response.negotiation)
        this.router.navigate(['negotiation/checkout'])
      }
    });
  }

  removeItemFromCart(id: any){
    this.negotiationService.removeItemFromCart(id).subscribe({
      next:(response) => {
        this.flashMessage.success(response.message)
      }
    });
  }
}
