import { CommonModule } from '@angular/common';
import { Component } from '@angular/core';
import { ReactiveFormsModule } from '@angular/forms';
import { RouterLink, RouterModule } from '@angular/router';

@Component({
  selector: 'app-user-negotiation',
  imports: [CommonModule, RouterLink, RouterModule, ReactiveFormsModule],
  templateUrl: './user-negotiation.component.html',
  styleUrl: './user-negotiation.component.scss',
})
export class UserNegotiationComponent {}
