import { Routes } from '@angular/router';
import { CartComponent } from './pages/cart/cart.component';
import { PaymentComponent } from './pages/payment/payment.component';

export const NEGOTIATION_ROUTES: Routes = [

  {
    path: 'cart',
    component: CartComponent
  },

  {
    path: 'payment',
    component: PaymentComponent
  }
];