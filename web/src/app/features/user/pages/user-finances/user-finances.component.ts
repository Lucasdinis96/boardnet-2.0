import { CommonModule } from '@angular/common';
import { Component } from '@angular/core';
import { RouterLink, RouterModule } from '@angular/router';

@Component({
  selector: 'app-user-finances',
  imports: [CommonModule, RouterLink, RouterModule],
  templateUrl: './user-finances.component.html',
  styleUrl: './user-finances.component.scss',
})
export class UserFinancesComponent {}
