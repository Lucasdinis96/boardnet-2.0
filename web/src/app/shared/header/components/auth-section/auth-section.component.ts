import { Component, inject} from '@angular/core';
import { AuthService } from '../../../../core/services/auth.service';
import { CommonModule } from '@angular/common';
import { LoginModalComponent } from '../../../login-modal/login-modal.component';
import { Router } from '@angular/router';

@Component({
  selector: 'app-auth-section',
  imports: [CommonModule, LoginModalComponent],
  templateUrl: './auth-section.component.html',
  styleUrl: './auth-section.component.scss',
})
export class AuthSectionComponent {

  private authService = inject(AuthService);
  private router = inject(Router)

  showLoginModal = false;

  isLogged$ = this.authService.isLoggedIn$;
  user$ = this.authService.user$;

  openLogin () {
    this.showLoginModal = true;
  }

  closeLogin() {
    this.showLoginModal = false;
  }

  logout() {
    this.authService.logout().subscribe({
      next: (res) => this.router.navigate(['/home']),
      error: () =>{
        this.authService.removeToken()
        this.authService.logout();
      }});
  }
}
