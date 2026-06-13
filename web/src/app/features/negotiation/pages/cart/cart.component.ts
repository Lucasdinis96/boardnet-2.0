import { CommonModule } from '@angular/common';
import { Component, inject, Output, ViewChild } from '@angular/core';
import { Router, RouterLink } from '@angular/router';
import { NegotiationService } from '../../services/negotiation.service';
import { AddressFormComponent } from '../../../../shared/components/address-form/address-form.component';
import { FlashMessageService } from '../../../../core/services/flash-message.service';
import { NegotiationStateService } from '../../services/negotiation-state.service';
import { FormsModule } from '@angular/forms';
import { BehaviorSubject, switchMap } from 'rxjs';

@Component({
  selector: 'app-cart',
  imports: [CommonModule, RouterLink, AddressFormComponent, FormsModule],
  templateUrl: './cart.component.html',
  styleUrl: './cart.component.scss',
})
export class CartComponent {
  private negotiationService = inject(NegotiationService);
  private stateService = inject(NegotiationStateService);
  private flashMessage = inject(FlashMessageService);
  private router = inject(Router);
  private refresh$ = new BehaviorSubject<void>(undefined);
  paymentMethods = [
    {id: null, method: null, name: 'Selecione uma opção...'},
    {id: 1, method: 'PIX', name: 'Pix'},
    {id: 2, method: 'CARD', name: 'Cartão de Crédito'}
  ]
  installments = [
    {id: 1, installments: 1, name: '1 parcela'},
    {id: 2, installments: 2, name: '2 parcelas'},
    {id: 3, installments: 3, name: '3 parcelas'}
  ]
  selectedMethod = this.paymentMethods[0];
  selectedInstallments = this.installments[0]
  addressType: 'registered' | 'custom' = 'registered';
  shippingAddress: any = null;
  @ViewChild(AddressFormComponent)
  addressForm!: AddressFormComponent


  onAddressChange(address: any) {
    this.shippingAddress = address;
  }
  
  cart$ = this.refresh$.pipe(switchMap(() => this.negotiationService.getCart()))
  
  checkout(){
    if (!this.selectedMethod.method){
      this.flashMessage.warning('Escolha um método de pagamento!')
      return
    }
    const paymentMethod = {
      payment_method: this.selectedMethod.method
    }
    const address = {
      use_registered_address: this.addressType === 'registered',
      shipping_address: this.addressType === 'custom' ? this.addressForm.addressForm.getRawValue() : null
    }
  
    this.negotiationService.checkout(address).subscribe({
      next:(response) => {
          this.negotiationService.createPayment(paymentMethod, response.negotiation.id).subscribe({
            next:(response) => {
              this.flashMessage.success(response.message),
              this.stateService.setPayment(response.payment)
              this.router.navigate(['negotiation/payment'])
            },
            error:() => {this.flashMessage.warning('Erro ao criar o checkout')}
          })
      },
      error: (response) => {this.flashMessage.error(response.error.message)}
    });
  }

  removeItemFromCart(id: any){
    console.log(id);
    this.negotiationService.removeItemFromCart(id).subscribe({
      next:(response) => {
        this.flashMessage.success(response.message)
        this.refresh$.next()
      },
      error: (response) => {this.flashMessage.error(response.error.message)}
    });
  }

  clearCart() {
    this.negotiationService.clearCart().subscribe({
      next: (response) => {this.flashMessage.success(response.message), this.refresh$.next()}
    })
  }
}
