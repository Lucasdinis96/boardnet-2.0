import { CommonModule } from '@angular/common';
import { Component, inject } from '@angular/core';
import { ReactiveFormsModule } from '@angular/forms';
import { UserService } from '../../../../services/user.service';
import { AuthService } from '../../../../../../core/services/auth.service';
import { FlashMessageService } from '../../../../../../core/services/flash-message.service';
import { BehaviorSubject, map, switchMap, tap } from 'rxjs';
import { PaginationComponent } from '../../../../../../shared/components/pagination/pagination.component';

@Component({
  selector: 'app-user-payments',
  imports: [CommonModule, ReactiveFormsModule, PaginationComponent],
  templateUrl: './user-payments.component.html',
  styleUrl: './user-payments.component.scss',
})
export class UserPaymentsComponent {

  private userService = inject(UserService)
  private authService = inject(AuthService)
  private flashMessage = inject(FlashMessageService)
  private refresh$ = new BehaviorSubject<void>(undefined);
  pagination = {
    currentPage: 1,
    lastPage: 1,
    perPage: 0,
    total: 0
  };

  negotiation$ = this.refresh$.pipe(switchMap(() => this.userService.getNegotiationAsBuyer()));

  ngOnInit() {
    this.loadPage();
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
}
