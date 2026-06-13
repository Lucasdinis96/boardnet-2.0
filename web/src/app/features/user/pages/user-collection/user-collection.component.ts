import { Component, inject } from '@angular/core';
import { UserService } from '../../services/user.service';
import { CommonModule } from '@angular/common';
import { RouterLink } from '@angular/router';
import { PaginationComponent } from '../../../../shared/components/pagination/pagination.component';
import { BehaviorSubject, map, Observable, switchMap, tap } from 'rxjs';
import { FlashMessageService } from '../../../../core/services/flash-message.service';

@Component({
  selector: 'app-user-collection',
  imports: [CommonModule, RouterLink, PaginationComponent],
  templateUrl: './user-collection.component.html',
  styleUrl: './user-collection.component.scss',
})
export class UserCollectionComponent {

  private userService = inject(UserService);
  private flashMessage = inject(FlashMessageService)
  id: any = localStorage.getItem('id');
  currentPage = 1
  pagination = {
    currentPage: 1,
    lastPage: 1,
    perPage: 0,
    total: 0
  };
  private refresh$ = new BehaviorSubject<void>(undefined);
  $collection = this.refresh$.pipe(
    switchMap (() => this.userService.getCollection(this.currentPage, this.id)),
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


  removeFromCollection(id: any){
    this.userService.removeFromCollection(id).subscribe({
      next: (response) => {console.log(response), this.flashMessage.success(response.message), this.refresh$.next()},
      error: (response) => {this.flashMessage.error(response.error.message)}
    })
  }

  ngOnInit() {
    this.loadPage()
  }

  loadPage(page: number = 1) {
    this.currentPage = page;
    this.refresh$.next();
  }

}
