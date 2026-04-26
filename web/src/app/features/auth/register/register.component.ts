import { CommonModule } from '@angular/common';
import { Component, inject, OnInit } from '@angular/core';
import { RegisterService } from './register.service';
import { FormControl, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { CityService } from '../../../shared/services/city.service';
import { debounceTime, distinctUntilChanged, Observable, of, switchMap } from 'rxjs';
import { RegisterFormType } from './types/register-form.type';
import { RegisterRequest } from './models/register';
import { Router } from '@angular/router';

@Component({
  selector: 'app-register',
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule],
  templateUrl: './register.component.html',
  styleUrl: './register.component.scss',
})
export class RegisterComponent implements OnInit {
  private registerService = inject(RegisterService);
  private cityService = inject(CityService);
  private router = inject(Router);
  cities$!: Observable<string []>;
  registerForm!: FormGroup<RegisterFormType>;
  isDropdownOpen = false;

  ngOnInit(){
    this.initializeForm();
    this.getCities();
    this.fillMockData();
  }
  
  initializeForm(){
    this.registerForm = new FormGroup<RegisterFormType>({
      name: new FormControl(null),
      birthdate: new FormControl(null),
      phone: new FormControl(null),
      cep: new FormControl(null),
      adress_name: new FormControl(null),
      adress_number: new FormControl(null),
      neighborhood: new FormControl(null),
      city: new FormControl(null),
      city_id: new FormControl(null),
      email: new FormControl(null),
      password: new FormControl(null),
      password_confirm: new FormControl(null)
    })
  }

  submit(){
    this.registerUser();
  }

  registerUser(){
    const formValue = this.registerForm.value;
    const userId = localStorage.getItem('id');
    const payload: RegisterRequest = {
      name: formValue.name!,
      birthdate: formValue.birthdate!,
      phone: formValue.phone!,
      cep: formValue.cep!,
      adress_name: formValue.adress_name!,
      adress_number: formValue.adress_number!,
      neighborhood: formValue.neighborhood!,
      city_id: formValue.city_id!,
      email: formValue.email!,
      password: formValue.password!,
      password_confirm: formValue.password_confirm!,
    };
    this.registerService.registerUser(payload).subscribe({
      next: () => {
        console.log('Usuário registrado')
        this.router.navigateByUrl('/home');
      },
      error: () => {console.log('Erro ao registrar')}
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
      adress_name: 'Rua Teste',
      adress_number: '123',
      neighborhood: 'Centro',
      city: 'Curitiba - PR',
      city_id: 123,
      email: 'teste@email.com',
      password: '123456',
      password_confirm: '123456'
    });
  }
}
