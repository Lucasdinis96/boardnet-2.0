import { CommonModule } from '@angular/common';
import { Component, inject, OnInit } from '@angular/core';
import { FormControl, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { debounceTime, distinctUntilChanged, Observable, of, switchMap } from 'rxjs';
import { RegisterService } from '../../../../../auth/register/register.service';
import { CityService } from '../../../../../../core/services/city.service';
import { UserService } from '../../../../services/user.service';
import { FlashMessageService } from '../../../../../../core/services/flash-message.service';


@Component({
  selector: 'app-user-address',
  imports: [CommonModule, ReactiveFormsModule],
  templateUrl: './user-address.component.html',
  styleUrl: './user-address.component.scss',
})
export class UserAddressComponent {
  private registerService = inject(RegisterService);
  private cityService = inject(CityService);
  private userService = inject(UserService);
  private flashMessage = inject(FlashMessageService)
  cities$!: Observable<any[]>;
  addressForm!: FormGroup;
  isDropdownOpen = false;
  userInfo: any;
  user: any;
  message: any;
  id: any;

  ngOnInit(){
    this.initializeForm();
    this.loadAddress();
    this.getCities();

  }

  loadAddress(){
    this.id = localStorage.getItem('id');
    this.userService.getAddress(this.id).subscribe(address => {
      this.addressForm.patchValue({
        cep: address.cep,
        address_name: address.address,
        address_number: address.number,
        neighborhood: address.neighborhood,
        city_id: address.city.id,
        city: address.city ? `${address.city.name} - ${address.city.state}`:null
      });
    });
  }
  
  initializeForm(){
    this.addressForm = new FormGroup<any>({
      cep: new FormControl(null),
      address_name: new FormControl(null),
      address_number: new FormControl(null),
      neighborhood: new FormControl(null),
      city: new FormControl(null),
      city_id: new FormControl(null)
    })
  }

  submit(){
    this.updateUser();
  }

  updateUser(){
    const formValue = this.addressForm.value;
    const id = localStorage.getItem('id');
    const payload = {
      cep: formValue.cep!,
      address: formValue.address_name!,
      number: formValue.address_number!,
      neighborhood: formValue.neighborhood!,
      city: formValue.city!,
      city_id: formValue.city_id!,
      id: id ? Number(id) : null,
    };
    this.userService.updateAddress(payload, id).subscribe({
      next: (response) => {this.flashMessage.success(response.message)},
      error: (response) => {this.flashMessage.error(response.error.message)}
    });
  }

  getCities(){
    this.cities$ = this.addressForm.controls['city'].valueChanges.pipe(
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
    this.addressForm.patchValue({
      city: city.name,
      city_id: city.id
    },
    { emitEvent: false}
  );
    this.isDropdownOpen = false;
  }
}
