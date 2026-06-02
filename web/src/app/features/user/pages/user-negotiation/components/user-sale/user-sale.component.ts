import { Component, inject } from '@angular/core';
import { UserService } from '../../../../services/user.service';
import { CommonModule } from '@angular/common';
import { AuthService } from '../../../../../../core/services/auth.service';
import { FormControl, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { FlashMessageService } from '../../../../../../core/services/flash-message.service';
import { BehaviorSubject, switchMap } from 'rxjs';

@Component({
  selector: 'app-user-sale',
  imports: [CommonModule, ReactiveFormsModule],
  templateUrl: './user-sale.component.html',
  styleUrl: './user-sale.component.scss',
})
export class UserSaleComponent {

  private userService = inject(UserService)
  private authService = inject(AuthService)
  private flashMessage = inject(FlashMessageService)
  private refresh$ = new BehaviorSubject<void>(undefined);
  trackingCode!: FormGroup

  negotiation$ = this.refresh$.pipe(switchMap(() => this.userService.getNegotiationAsSeller()));
  user$ = this.authService.user$;

  ngOnInit() {
    this.initializeForm();
  }

  initializeForm() {
    this.trackingCode = new FormGroup<any>({
      trackingCode: new FormControl(null)
    })
  }
  
  submit(id: any) {
    this.confirmShipping(id);
  }

  confirmShipping(id: any) {
    const formValue = this.trackingCode.value
    const payload = {
      tracking_code: formValue.trackingCode!
    }
    this.userService.confirmShipping(payload, id).subscribe({
      next: (response) => {
        this.flashMessage.success(response.message),
        this.refresh$.next()
      },
      error: (response) => {this.flashMessage.warning(response.error.message)}
    })
  }
}
