import { Injectable, signal } from '@angular/core';

@Injectable({
  providedIn: 'root',
})
export class NegotiationStateService {
  negotiation = signal<any | null>(null);
  payment = signal<any | null>(null);
  
  setNegotiation(data: any){
    this.negotiation.set(data);
  }

  setPayment(data: any){
    this.payment.set(data);
  }

  getNegotiation(){
    return this.negotiation();
  }

  clear(){
    this.negotiation.set(null);
  }
}
