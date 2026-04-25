import { Component, inject } from '@angular/core';
import { UserService } from '../../user.service';
import { CommonModule } from '@angular/common';
import { RouterLink } from '@angular/router';

@Component({
  selector: 'app-user-collection',
  imports: [CommonModule, RouterLink],
  templateUrl: './user-collection.component.html',
  styleUrl: './user-collection.component.scss',
})
export class UserCollectionComponent {

  private userService = inject(UserService);
  id: any = localStorage.getItem('id');
  $collection = this.userService.getCollection(this.id);

  removeFromCollection(id: any){
    console.log('teste chamada');
    this.userService.removeFromCollection(id).subscribe()
  }

}
