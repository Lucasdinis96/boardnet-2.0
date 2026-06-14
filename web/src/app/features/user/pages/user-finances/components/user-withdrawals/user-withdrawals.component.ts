import { Component, inject, OnInit } from '@angular/core';
import { UserService } from '../../../../services/user.service';
import { Withdrawal } from '../../../../models/WithdrawalModel';
import { CommonModule } from '@angular/common';
import { map, Observable, tap } from 'rxjs';
import { PaginationComponent } from '../../../../../../shared/components/pagination/pagination.component';
import { FlashMessageService } from '../../../../../../core/services/flash-message.service';

@Component({
    selector: 'app-user-withdrawals',
    imports: [CommonModule, PaginationComponent],
    templateUrl: './user-withdrawals.component.html',
    styleUrl: './user-withdrawals.component.scss'
})
export class UserWithdrawalsComponent implements OnInit {


    withdrawals$!: Observable<Withdrawal[]>;

    pagination = {
        currentPage: 1,
        lastPage: 1,
        perPage: 10,
        total: 0
    };

    loading = false;

    private userService = inject(UserService)
    private flashMessage = inject(FlashMessageService)

    ngOnInit(): void {
        this.loadPage();
    }

    loadPage(page: number = 1) {

    this.withdrawals$ = this.userService
        .getWithdrawals(page)
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

    requestWithdrawal(id: number): void {

      if (!confirm('Deseja solicitar este saque?')) {
        return;
      }

      this.userService.requestWithdrawal(id).subscribe({
            next: (response: any) => {
              this.flashMessage.success(response.message),
              this.loadPage(this.pagination.currentPage)
            },
            error: (response) => {
              this.flashMessage.error(response.error.message)
            }
          });
      }

    getStatusLabel(status: string): string {

    switch (status) {

        case 'available':
            return 'Disponível';

        case 'requested':
            return 'Solicitado';

        case 'paid':
            return 'Pago';

        case 'cancelled':
            return 'Cancelado';

        default:
            return status;
    }
}
}