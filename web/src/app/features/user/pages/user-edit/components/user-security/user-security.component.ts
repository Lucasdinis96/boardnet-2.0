import { ChangeDetectorRef, Component, inject, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormControl, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { UserService } from '../../../../services/user.service';
import { AuthService } from '../../../../../../core/services/auth.service';
import { FlashMessageService } from '../../../../../../core/services/flash-message.service';
import { passwordMatchValidator } from '../../../../../../core/validators/password-match.validator';


@Component({
  selector: 'app-user-security',
  imports: [CommonModule, ReactiveFormsModule],
  templateUrl: './user-security.component.html',
  styleUrl: './user-security.component.scss',
})
export class UserSecurityComponent implements OnInit {
  private userService = inject(UserService);
  private authService = inject(AuthService);
  private flashMessage = inject(FlashMessageService)
  private router = inject(Router);
  private cdr = inject(ChangeDetectorRef); 
  passwordForm!: FormGroup;
  deleteForm!: FormGroup;

  ngOnInit(): void {
    this.initializeForm();
  }

  initializeForm(){
    this.passwordForm = new FormGroup<any>({
      currentPassword: new FormControl(null),
      newPassword: new FormControl(null, {validators: [Validators.required, Validators.minLength(6)]}),
      confirmNewPassword: new FormControl(null, [Validators.required])}, 
        {
          validators: passwordMatchValidator('newPassword', 'confirmNewPassword') 
        });    
      this.deleteForm = new FormGroup<any> ({
      password: new FormControl(null)
    })
  }

  submit(){
    if (this.passwordForm.valid) {
      this.updatePassword();
    } else {
      this.passwordForm.markAllAsTouched();
      this.cdr.detectChanges();
    }
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
      error: (response) => {this.flashMessage.error(response.error.message)}
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
        this.flashMessage.success(response.message)
        this.authService.logout()
        this.router.navigateByUrl('/home')
      },
      error: (response) => {this.flashMessage.warning(response.error.message)}
    })
  }

    onFieldBlur(fieldName: any) {
      const control = this.passwordForm.get(fieldName);
      const value = control?.value;
  
      // Verifica se o usuário saiu do campo e ele está totalmente vazio
      if (value === null || value === undefined || String(value).trim() === '') {
        
        // 1. Reseta os estados visuais para esconder a validação de "required"
        control?.markAsUntouched({ emitEvent: false });
        control?.markAsPristine({ emitEvent: false });
        
        // 2. Se for um campo comum (que não seja e-mail ou senhas), limpa os erros locais  
        // 3. Se o campo limpo foi uma das senhas, remove o erro "passwordMismatch" do formulário global
        if (fieldName === 'newPassword' || fieldName === 'confirmNewpassword') {
          this.passwordForm.setErrors(null);
        }
        
        // Força o Angular a atualizar a tela imediatamente
        this.cdr.detectChanges();
      }
    }
}
