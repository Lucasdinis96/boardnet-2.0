import { Routes } from '@angular/router';
import { CartComponent } from './pages/cart/cart.component';
import { CheckoutComponent } from './pages/checkout/checkout.component';
import { PaymentComponent } from './pages/payment/payment.component';

export const NEGOTIATION_ROUTES: Routes = [

  {
    path: 'cart',
    component: CartComponent
  },

  {
    path: 'checkout',
    component: CheckoutComponent
  },

  {
    path: 'payment',
    component: PaymentComponent
  }
];