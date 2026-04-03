import { CommonModule } from '@angular/common';
import { Component, EventEmitter, inject, Output } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { AuthService } from '../../core/services/auth.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-login-modal',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './login-modal.component.html',
  styleUrls: ['./login-modal.component.scss']
})
export class LoginModalComponent {

  private authService = inject(AuthService);
  private router = inject(Router);

  @Output() close = new EventEmitter<void>();

  email = '';
  password = '';
  loading = false;
  error = '';

  submit() {
    this.loading = true;
    this.error = '';

    this.authService.login({
      email: this.email,
      password: this.password
    }).subscribe({
      next: () => {
        this.loading = false;
        this.close.emit();
        this.router.navigate(['/user']);
      },
      error: () => {
        this.loading = false;
        this.error = 'Login inválido';
      }
    });
  }

  onClose() {
    this.close.emit();
  }
}
