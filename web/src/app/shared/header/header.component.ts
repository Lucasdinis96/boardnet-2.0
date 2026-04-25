import { Component } from '@angular/core';
import { CommonModule, NgOptimizedImage } from '@angular/common';
import { AuthSectionComponent } from './components/auth-section/auth-section.component';
import { SearchBarComponent } from './components/searchBar/searchbar.component';
import { Route, RouterLink } from '@angular/router';

@Component({
  selector: 'app-header',
  imports: [CommonModule, NgOptimizedImage, AuthSectionComponent, SearchBarComponent, RouterLink],
  templateUrl: './header.component.html',
  styleUrl: './header.component.scss',
})
export class HeaderComponent {}
