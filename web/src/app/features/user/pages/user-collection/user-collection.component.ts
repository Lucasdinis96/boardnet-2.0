import { Component, inject } from '@angular/core';
import { UserService } from '../../services/user.service';
import { CommonModule } from '@angular/common';
import { RouterLink } from '@angular/router';
import { PaginationComponent } from '../../../../shared/components/pagination/pagination.component';
import { map, Observable, tap } from 'rxjs';

@Component({
  selector: 'app-user-collection',
  imports: [CommonModule, RouterLink, PaginationComponent],
  templateUrl: './user-collection.component.html',
  styleUrl: './user-collection.component.scss',
})
export class UserCollectionComponent {

  private userService = inject(UserService);
  id: any = localStorage.getItem('id');
  pagination = {
    currentPage: 1,
    lastPage: 1,
    perPage: 0,
    total: 0
  };
  $collection!: Observable<any[]>;

  removeFromCollection(id: any){
    this.userService.removeFromCollection(id).subscribe()
  }

  ngOnInit() {
    this.loadPage()
  }

  loadPage(page: number = 1) {
    this.$collection = this.userService.getCollection(page, this.id).pipe(
      tap(response => {this.pagination = {
        currentPage: response.meta.current_page,
        lastPage: response.meta.last_page,
        perPage: response.meta.per_page,
        total: response.meta.total
      };}),
      map(response => this.prepareGames(response.data))
    );
  }

  private prepareGames(games: any[]) {
      return games.map(game => ({
        ...game,
        primaryImage:
          game.images?.find(
            (image: any) => image.is_primary
          )?.path ?? null
      }));
    }

}
