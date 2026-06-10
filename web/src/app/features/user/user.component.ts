import { Component, inject } from '@angular/core';
import { AuthService } from '../../core/services/auth.service';
import { CommonModule } from '@angular/common';
import { RouterLink, RouterModule } from '@angular/router';
import { AvatarUrlPipe } from '../../shared/pipes/avatar-url-pipe';

@Component({
  selector: 'app-user',
  imports: [CommonModule, RouterLink, RouterModule, AvatarUrlPipe],
  templateUrl: './user.component.html',
  styleUrl: './user.component.scss',
})
export class UserComponent {
  private authService = inject(AuthService);

  user$ = this.authService.user$;

}
