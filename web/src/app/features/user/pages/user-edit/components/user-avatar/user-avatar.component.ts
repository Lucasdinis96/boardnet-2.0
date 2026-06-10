import { CommonModule } from '@angular/common';
import { Component, inject } from '@angular/core';
import { UserService } from '../../../../services/user.service';
import { FlashMessageService } from '../../../../../../core/services/flash-message.service';
import { User } from '../../../../../../core/models/user';
import { environment } from '../../../../../../../environments/environment';
import { AuthService } from '../../../../../../core/services/auth.service';
import { AvatarUrlPipe } from '../../../../../../shared/pipes/avatar-url-pipe';

@Component({
  selector: 'app-user-avatar',
  imports: [CommonModule, AvatarUrlPipe],
  templateUrl: './user-avatar.component.html',
  styleUrl: './user-avatar.component.scss',
})
export class UserAvatarComponent {
  private userService = inject(UserService);
  private flashMessenge = inject(FlashMessageService)
  private authService = inject(AuthService)
  selectedFile: File | null = null;
  previewUrl: string | null = null;
  user: User | null = null
  user$ = this.authService.user$
  avatarVersion = Date.now()



  onFileSelected(event: Event): void {
    const input = event.target as HTMLInputElement;

    if (!input.files?.length) {
      return
    }
     const file = input.files[0];

    this.selectedFile = file;

    const reader = new FileReader();

    reader.onload = () => {
      this.previewUrl = reader.result as string;
    };

    reader.readAsDataURL(this.selectedFile);
  }

  uploadAvatar(): void {
    if (!this.selectedFile) {
      return;
    }

    this.userService.updateAvatar(this.selectedFile).subscribe({
      next: (response) => {
        this.flashMessenge.success(response.message),
        this.avatarVersion = Date.now()
        window.location.reload()
      },
      error: (response) => {this.flashMessenge.error(response.error.message)}
    })
  }  
}
