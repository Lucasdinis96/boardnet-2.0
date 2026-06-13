import { Component, inject } from '@angular/core';
import { UserService } from '../../../../services/user.service';
import { CommonModule } from '@angular/common';
import { AuthService } from '../../../../../../core/services/auth.service';
import { FormControl, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { FlashMessageService } from '../../../../../../core/services/flash-message.service';
import { BehaviorSubject, map, Observable, switchMap, tap } from 'rxjs';
import { PaginationComponent } from '../../../../../../shared/components/pagination/pagination.component';

@Component({
  selector: 'app-user-sale',
  imports: [CommonModule, ReactiveFormsModule, PaginationComponent],
  templateUrl: './user-sale.component.html',
  styleUrl: './user-sale.component.scss',
})
export class UserSaleComponent {

  private userService = inject(UserService)
  private authService = inject(AuthService)
  private flashMessage = inject(FlashMessageService)
  private refresh$ = new BehaviorSubject<void>(undefined);
  trackingCode!: FormGroup
  pagination = {
    currentPage: 1,
    lastPage: 1,
    perPage: 0,
    total: 0
  };

  negotiation$!: Observable<any[]>;
  user$ = this.authService.user$;

  ngOnInit() {
    this.initializeForm();
    this.loadPage();
  }

  initializeForm() {
    this.trackingCode = new FormGroup<any>({
      shippingCompany: new FormControl(null),
      trackingCode: new FormControl(null)
    })
  }
  
  submit(id: any) {
    this.confirmShipping(id);
  }

  confirmShipping(id: any) {
    const formValue = this.trackingCode.value
    const payload = {
      shipping_company: formValue.shippingCompany!,
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

  loadPage(page: number = 1) {
    this.negotiation$ = this.userService
      .getNegotiationAsSeller(page)
      .pipe(
        tap(response => {
          this.pagination = {
            currentPage: response.meta.current_page,
            lastPage: response.meta.last_page,
            perPage: response.meta.per_page,
            total: response.meta.total
          };
        }),
        map(response => response.data)
      );
  }
}
