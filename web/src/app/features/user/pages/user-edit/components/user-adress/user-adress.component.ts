import { CommonModule } from '@angular/common';
import { Component, inject, OnInit } from '@angular/core';
import { FormControl, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { debounceTime, distinctUntilChanged, Observable, of, switchMap } from 'rxjs';
import { RegisterService } from '../../../../../auth/register/register.service';
import { CityService } from '../../../../../../shared/services/city.service';
import { UserService } from '../../../../user.service';


@Component({
  selector: 'app-user-adress',
  imports: [CommonModule, ReactiveFormsModule],
  templateUrl: './user-adress.component.html',
  styleUrl: './user-adress.component.scss',
})
export class UserAdressComponent {
  private registerService = inject(RegisterService);
  private cityService = inject(CityService);
  private userService = inject(UserService);
  cities$!: Observable<any[]>;
  adressForm!: FormGroup;
  isDropdownOpen = false;
  userInfo: any;
  user: any;
  message: any;
  id: any;

  ngOnInit(){
    this.initializeForm();
    this.loadAdress();
    this.getCities();

  }

  loadAdress(){
    this.id = localStorage.getItem('id');
    this.userService.getAdress(this.id).subscribe(adress => {
      this.adressForm.patchValue({
        cep: adress.cep,
        adress_name: adress.adress,
        adress_number: adress.number,
        neighborhood: adress.neighborhood,
        city_id: adress.city.id,
        city: adress.city ? `${adress.city.name} - ${adress.city.state}`:null
      });
    });
  }
  
  initializeForm(){
    this.adressForm = new FormGroup<any>({
      cep: new FormControl(null),
      adress_name: new FormControl(null),
      adress_number: new FormControl(null),
      neighborhood: new FormControl(null),
      city: new FormControl(null),
      city_id: new FormControl(null)
    })
  }

  submit(){
    this.updateUser();
  }

  updateUser(){
    const formValue = this.adressForm.value;
    const id = localStorage.getItem('id');
    const payload = {
      cep: formValue.cep!,
      adress: formValue.adress_name!,
      number: formValue.adress_number!,
      neighborhood: formValue.neighborhood!,
      city: formValue.city!,
      city_id: formValue.city_id!,
      id: id ? Number(id) : null,
    };
    this.userService.updateAdress(payload, id).subscribe({
      next: (response) => {console.log(response.message)},
      error: () => {console.log('Erro ao registrar')}
    });
  }

  getCities(){
    this.cities$ = this.adressForm.controls['city'].valueChanges.pipe(
      debounceTime(300),
      distinctUntilChanged(),
      switchMap((term: string | null) => {
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
    this.adressForm.patchValue({
      city: city.name,
      city_id: city.id
    },
    { emitEvent: false}
  );
    
    this.isDropdownOpen = false;
  }
}
