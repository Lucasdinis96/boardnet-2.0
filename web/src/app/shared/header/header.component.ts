import { Component, inject } from '@angular/core';
import { CommonModule, NgOptimizedImage } from '@angular/common';
import { AuthSectionComponent } from './components/auth-section/auth-section.component';
import { NavSectionComponent } from './components/nav-section/nav-section.component';
import { Route, RouterLink, RouterLinkActive } from '@angular/router';
import { AuthService } from '../../core/services/auth.service';

@Component({
  selector: 'app-header',
  imports: [CommonModule, NgOptimizedImage, AuthSectionComponent, NavSectionComponent],
  templateUrl: './header.component.html',
  styleUrl: './header.component.scss',
})
export class HeaderComponent {
    private authService = inject(AuthService)
    isLogged$ = this.authService.isLoggedIn$;

}
