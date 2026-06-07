import { Component, inject } from '@angular/core';
import { CommonModule, NgOptimizedImage } from '@angular/common';
import { AuthSectionComponent } from './components/auth-section/auth-section.component';
import { SearchBarComponent } from './components/searchBar/searchbar.component';
import { Route, RouterLink, RouterLinkActive } from '@angular/router';
import { AuthService } from '../../core/services/auth.service';

@Component({
  selector: 'app-header',
  imports: [CommonModule, NgOptimizedImage, AuthSectionComponent, SearchBarComponent, RouterLink, RouterLinkActive],
  templateUrl: './header.component.html',
  styleUrl: './header.component.scss',
})
export class HeaderComponent {
    private authService = inject(AuthService)
    isLogged$ = this.authService.isLoggedIn$;

}
