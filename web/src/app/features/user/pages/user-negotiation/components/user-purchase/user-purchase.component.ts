import { Component, inject } from '@angular/core';
import { UserService } from '../../../../services/user.service';
import { CommonModule } from '@angular/common';
import { AuthService } from '../../../../../../core/services/auth.service';
import { FormControl, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { FlashMessageService } from '../../../../../../core/services/flash-message.service';
import { BehaviorSubject, switchMap } from 'rxjs';

@Component({
  selector: 'app-user-purchase',
  imports: [CommonModule, ReactiveFormsModule],
  templateUrl: './user-purchase.component.html',
  styleUrl: './user-purchase.component.scss',
})
export class UserPurchaseComponent {

  private userService = inject(UserService)
  private authService = inject(AuthService)
  private flashMessage = inject(FlashMessageService)
  private refresh$ = new BehaviorSubject<void>(undefined);
  trackingCode!: FormGroup

  negotiation$ = this.refresh$.pipe(switchMap(() => this.userService.getNegotiationAsBuyer()));
  user$ = this.authService.user$;

  ngOnInit() {
    this.initializeForm();
  }

  initializeForm() {
    this.trackingCode = new FormGroup<any>({
      trackingCode: new FormControl(null)
    })
  }
  
  received(id: any) {
    const payload = {
      id: id
    }
    this.userService.confirmReceivement(payload).subscribe({
      next: (response) => {this.flashMessage.success(response.message),this.refresh$.next()},
      error: (response) => {this.flashMessage.error(response.error.message)}
    })
  }

  


}
