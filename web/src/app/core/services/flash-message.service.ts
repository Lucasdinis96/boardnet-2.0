import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs';

export interface FlashMessage {
  type: 'success' | 'error' | 'warning' | 'info';
  text: string;
}

@Injectable({
  providedIn: 'root'
})
export class FlashMessageService {

  private messageSubject = new BehaviorSubject<FlashMessage | null>(null);

  message$ = this.messageSubject.asObservable();

  show(message: FlashMessage) {
    this.messageSubject.next(message);

    setTimeout(() => {
      this.clear();
    }, 4000);
  }

  clear() {
    this.messageSubject.next(null);
  }

  success(text: string) {
    this.show({
      type: 'success',
      text
    });
  }

  error(text: string) {
    this.show({
      type: 'error',
      text
    });
  }

  warning(text: string) {
    this.show({
      type: 'warning',
      text
    });
  }

  info(text: string) {
    this.show({
      type: 'info',
      text
    });
  }
}