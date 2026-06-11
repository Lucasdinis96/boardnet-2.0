import { Component, inject } from '@angular/core';
import { UserService } from '../../../../services/user.service';
import { CommonModule } from '@angular/common';
import { AuthService } from '../../../../../../core/services/auth.service';
import { FormControl, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { FlashMessageService } from '../../../../../../core/services/flash-message.service';
import { BehaviorSubject, map, Observable, switchMap, tap } from 'rxjs';
import { PaginationComponent } from '../../../../../../shared/components/pagination/pagination.component';

@Component({
  selector: 'app-user-purchase',
  imports: [CommonModule, ReactiveFormsModule, PaginationComponent],
  templateUrl: './user-purchase.component.html',
  styleUrl: './user-purchase.component.scss',
})
export class UserPurchaseComponent {

  private userService = inject(UserService)
  private authService = inject(AuthService)
  private flashMessage = inject(FlashMessageService)
  private refresh$ = new BehaviorSubject<void>(undefined);
  trackingCode!: FormGroup
  negotiation$!: Observable<any[]>;
  user$ = this.authService.user$;
  pagination = {
    currentPage: 1,
    lastPage: 1,
    perPage: 0,
    total: 0
  };

  ngOnInit() {
    this.initializeForm();
    this.loadPage();
  }

  initializeForm() {
    this.trackingCode = new FormGroup<any>({
      trackingCode: new FormControl(null)
    })
  }

  loadPage(page: number = 1) {
  this.negotiation$ = this.userService
    .getNegotiationAsBuyer(page)
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
