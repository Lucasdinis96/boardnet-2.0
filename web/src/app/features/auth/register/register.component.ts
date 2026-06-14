import { CommonModule } from '@angular/common';
import { ChangeDetectorRef, Component, inject, OnInit } from '@angular/core';
import { RegisterService } from './register.service';
import { FormControl, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { CityService } from '../../../core/services/city.service';
import { debounceTime, distinctUntilChanged, Observable, of, switchMap } from 'rxjs';
import { RegisterFormType } from './types/register-form.type';
import { RegisterRequest } from './models/register';
import { Router } from '@angular/router';
import { FlashMessageService } from '../../../core/services/flash-message.service';
import { NgxMaskDirective } from 'ngx-mask';
import { passwordMatchValidator } from '../../../core/validators/password-match.validator';

@Component({
  selector: 'app-register',
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule, NgxMaskDirective],
  templateUrl: './register.component.html',
  styleUrl: './register.component.scss',
})
export class RegisterComponent implements OnInit {
  private registerService = inject(RegisterService);
  private cityService = inject(CityService);
  private flashMessage = inject(FlashMessageService)
  private router = inject(Router);
  private cdr = inject(ChangeDetectorRef); 
  cities$!: Observable<any []>;
  registerForm!: FormGroup<RegisterFormType>;
  isDropdownOpen = false;

  ngOnInit(){
    this.initializeForm();
    this.getCities();
    this.fillMockData();
  }
  
  initializeForm(){
    this.registerForm = new FormGroup<RegisterFormType>({
      name: new FormControl(null, {validators: [Validators.required]}),
      birthdate: new FormControl(null),
      phone: new FormControl(null),
      cep: new FormControl(null),
      address_name: new FormControl(null),
      address_number: new FormControl(null),
      neighborhood: new FormControl(null),
      city: new FormControl(null),
      city_id: new FormControl(null),
      email: new FormControl(null, {validators: [Validators.required, Validators.email]}),
      password: new FormControl(null, {validators: [Validators.required, Validators.minLength(6)]}),
      password_confirm: new FormControl(null, [Validators.required])}, 
      {
        validators: passwordMatchValidator('password', 'password_confirm') 
      });
  }

  submit(){
    if (this.registerForm.valid) {
      this.registerUser();
    } else {
      this.registerForm.markAllAsTouched();
      this.cdr.detectChanges();
    }
    
  }

  registerUser(){
    const formValue = this.registerForm.value;
    const payload: RegisterRequest = {
      name: formValue.name!,
      birthdate: formValue.birthdate!,
      phone: formValue.phone!,
      cep: formValue.cep!,
      address_name: formValue.address_name!,
      address_number: formValue.address_number!,
      neighborhood: formValue.neighborhood!,
      city_id: formValue.city_id!,
      email: formValue.email!,
      password: formValue.password!,
      password_confirm: formValue.password_confirm!,
    };
    this.registerService.registerUser(payload).subscribe({
      next: (response) => {
        this.flashMessage.success(response.message),
        this.router.navigate(['/register-sucess'], {replaceUrl: true})
      },
      error: (response) => {this.flashMessage.error(response.error.message)}
    });
  }

  getCities(){
    this.cities$ = this.registerForm.controls.city.valueChanges.pipe(
      debounceTime(300),
      distinctUntilChanged(),
      switchMap((term: string | null) => {
        console.log(term);
        if (!term || term.length < 2) {
          this.isDropdownOpen = false
          return of([]);
        }
        this.isDropdownOpen = true;
        return this.cityService.searchCities(term);
      })
    )
  }

  selectCity(city: any) {
    console.log(city);
    this.registerForm.patchValue({
      city: city.name,
      city_id: city.id
    },
    { emitEvent: false}
  );
    
    this.isDropdownOpen = false;
  }

  fillMockData() {
    this.registerForm.patchValue({
      name: 'Usuário Teste',
      birthdate: '1990-01-01',
      phone: '49999999999',
      cep: '00000000',
      address_name: 'Rua Teste',
      address_number: '123',
      neighborhood: 'Centro',
      city: 'Curitiba - PR',
      city_id: 123,
      email: 'teste@email.com',
      password: '123456',
      password_confirm: '123456'
    });
  }

  onFieldBlur(fieldName: keyof RegisterFormType) {
    const control = this.registerForm.get(fieldName);
    const value = control?.value;

    if (value === null || value === undefined || String(value).trim() === '') {
      
      control?.markAsUntouched({ emitEvent: false });
      control?.markAsPristine({ emitEvent: false });
      
      if (fieldName !== 'email' && fieldName !== 'password' && fieldName !== 'password_confirm') {
        control?.setErrors(null, { emitEvent: false });
      }

      if (fieldName === 'password' || fieldName === 'password_confirm') {
        this.registerForm.setErrors(null);
      }
      
      this.cdr.detectChanges();
    }
  }
}
