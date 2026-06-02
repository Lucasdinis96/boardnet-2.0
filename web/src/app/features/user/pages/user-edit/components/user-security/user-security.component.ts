import { Component, inject, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormControl, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { Router } from '@angular/router';
import { UserService } from '../../../../services/user.service';
import { AuthService } from '../../../../../../core/services/auth.service';


@Component({
  selector: 'app-user-security',
  imports: [CommonModule, ReactiveFormsModule],
  templateUrl: './user-security.component.html',
  styleUrl: './user-security.component.scss',
})
export class UserSecurityComponent implements OnInit {
  private userService = inject(UserService);
  private authService = inject(AuthService);
  private router = inject(Router);
  passwordForm!: FormGroup;
  deleteForm!: FormGroup;

  ngOnInit(): void {
    this.initializeForm();
  }

  initializeForm(){
    this.passwordForm = new FormGroup<any>({
      currentPassword: new FormControl(null),
      newPassword: new FormControl(null),
      confirmNewPassword: new FormControl(null),
      email: new FormControl(null),
    })
    this.deleteForm = new FormGroup<any> ({
      password: new FormControl(null)
    })
  }

  submit(){
    this.updatePassword();
  }

  updatePassword(){
    const formValue = this.passwordForm.value;
    const id = localStorage.getItem('id');
    const payload = {
      currentPassword: formValue.currentPassword!,
      newPassword: formValue.newPassword!,
      confirmNewPassword: formValue.confirmNewPassword!,
    }
    this.userService.updatePassword(payload, id).subscribe({
      next: (response) => {console.log(response.message)},
      error: (response) => {console.log('Falha ao atualizar a senha')}
    })
  }

  deleteAccount(){
    const formValue = this.deleteForm.value;
    const id = localStorage.getItem('id');
    const payload = {
      password: formValue.password!
    }
    this.userService.deleteAccount(payload, id).subscribe({
      next: (response) => {
        console.log(response.message)
        this.authService.logout()
        this.router.navigateByUrl('/home')
      },
      error: (response) => {console.log('Erro ao deletar conta')}
    })
  }
}
