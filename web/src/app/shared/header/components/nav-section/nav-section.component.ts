import { CommonModule } from '@angular/common';
import { Component } from '@angular/core';
import { RouterLink, RouterLinkActive } from '@angular/router';

@Component({
  selector: 'app-nav-section',
  imports: [CommonModule, RouterLink, RouterLinkActive],
  templateUrl: './nav-section.component.html',
  styleUrl: './nav-section.component.scss',
})
export class NavSectionComponent {}
