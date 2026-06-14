import { CommonModule } from '@angular/common';
import { ChangeDetectorRef, Component, inject, OnInit } from '@angular/core';
import { FormControl, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { debounceTime, distinctUntilChanged, Observable, of, switchMap } from 'rxjs';
import { RegisterService } from '../../../../../auth/register/register.service';
import { UserService } from '../../../../services/user.service';


@Component({
  selector: 'app-user-general',
  imports: [CommonModule, ReactiveFormsModule],
  templateUrl: './user-general.component.html',
  styleUrl: './user-general.component.scss',
})
export class UserGeneralComponent implements OnInit {

  private userService = inject(UserService);
  cities$!: Observable<any[]>;
  userForm!: FormGroup;
  private cdr = inject(ChangeDetectorRef); 
  isDropdownOpen = false;
  userInfo: any;
  user: any;
  message: any;
  id: any;

  ngOnInit(){
    this.initializeForm();
    this.loadUser();

  }

  loadUser(){
    this.id = localStorage.getItem('id');
    this.userService.getUser(this.id).subscribe(user => {
      this.userForm.patchValue({
        name: user.name,
        email: user.email,
        phone: user.phone,
        birthdate: user.birthdate
      });
    });
  }
  
  initializeForm(){
    this.userForm = new FormGroup<any>({
      name: new FormControl(null),
      birthdate: new FormControl(null),
      phone: new FormControl(null),
      email: new FormControl(null, {validators: [Validators.required, Validators.email]}),
    })
  }

  submit(){
    this.updateUser();
  }

  updateUser(){
    const formValue = this.userForm.value;
    const id = localStorage.getItem('id');
    const payload = {
      name: formValue.name!,
      birthdate: formValue.birthdate!,
      phone: formValue.phone!,
      email: formValue.email!,
      id: id ? Number(id) : null,
    };
    this.userService.updateUser(payload, id).subscribe({
      next: (response) => {this.message = response.message},
      error: () => {console.log('Erro ao registrar')}
    });
  }

  onFieldBlur(fieldName: any) {
      const control = this.userForm.get(fieldName);
      const value = control?.value;
  
      if (value === null || value === undefined || String(value).trim() === '') {
        
        control?.markAsUntouched({ emitEvent: false });
        control?.markAsPristine({ emitEvent: false });
        
        if (fieldName !== 'email' && fieldName !== 'password' && fieldName !== 'password_confirm') {
          control?.setErrors(null, { emitEvent: false });
        }
        
        this.cdr.detectChanges();
      }
    }
}