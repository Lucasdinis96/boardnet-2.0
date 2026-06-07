import { Component, inject} from '@angular/core';
import { AuthService } from '../../../../core/services/auth.service';
import { CommonModule } from '@angular/common';
import { Router, RouterLink, RouterLinkActive } from '@angular/router';
import { LoginComponent } from '../../../../features/auth/login/login.component';

@Component({
  selector: 'app-auth-section',
  imports: [CommonModule, LoginComponent, RouterLink, RouterLinkActive],
  templateUrl: './auth-section.component.html',
  styleUrl: './auth-section.component.scss',
})
export class AuthSectionComponent {

  private authService = inject(AuthService);
  private router = inject(Router)

  showLoginModal = false;

  isLogged$ = this.authService.isLoggedIn$;
  user$ = this.authService.user$;

  user(){
    this.authService
  }

  openLogin () {
    this.showLoginModal = true;
  }

  closeLogin() {
    this.showLoginModal = false;
  }

  logout() {
    this.authService.logout().subscribe({
      next: () => this.router.navigate(['/']),
      error: () =>{
        this.authService.removeToken()
        this.authService.logout();
      }});
  }
}
