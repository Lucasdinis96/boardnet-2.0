import { CommonModule } from '@angular/common';
import { Component, inject } from '@angular/core';
import { ReactiveFormsModule } from '@angular/forms';
import { UserService } from '../../../../services/user.service';
import { AuthService } from '../../../../../../core/services/auth.service';
import { FlashMessageService } from '../../../../../../core/services/flash-message.service';
import { BehaviorSubject, switchMap } from 'rxjs';

@Component({
  selector: 'app-user-payments',
  imports: [CommonModule, ReactiveFormsModule],
  templateUrl: './user-payments.component.html',
  styleUrl: './user-payments.component.scss',
})
export class UserPaymentsComponent {

  private userService = inject(UserService)
  private authService = inject(AuthService)
  private flashMessage = inject(FlashMessageService)
  private refresh$ = new BehaviorSubject<void>(undefined);

  negotiation$ = this.refresh$.pipe(switchMap(() => this.userService.getNegotiationAsBuyer()));

}
