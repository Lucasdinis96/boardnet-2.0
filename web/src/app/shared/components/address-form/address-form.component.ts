import { CommonModule } from '@angular/common';
import { Component, EventEmitter, inject, Input, Output } from '@angular/core';
import { FormControl, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { debounceTime, distinctUntilChanged, Observable, of, switchMap } from 'rxjs';
import { CityService } from '../../../core/services/city.service';

@Component({
  selector: 'app-address-form',
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule],
  templateUrl: './address-form.component.html',
  styleUrl: './address-form.component.scss',
})
export class AddressFormComponent {
  private cityService = inject(CityService);
  cities$!: Observable<any[]>;
  addressForm!: FormGroup;
  userAddress: any;
  isDropdownOpen = false;
  userInfo: any;
  user: any;
  message: any;
  id: any;
  @Input() initialData: any;
  @Output() submitAddress = new EventEmitter<any>();

  ngOnInit(){
    this.initializeForm();
    this.patchInitialData();
    this.getCities();
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

  patchInitialData(){

    if(!this.initialData){
      return;
    }

    this.addressForm.patchValue({

      cep: this.initialData.cep,

      address_name:
        this.initialData.address,

      address_number:
        this.initialData.number,

      neighborhood:
        this.initialData.neighborhood,

      city_id:
        this.initialData.city?.id,

      city:
        this.initialData.city

          ? `${this.initialData.city.name}
            - ${this.initialData.city.state}`

          : null
    });
  }

  submit(){
      if(this.addressForm.invalid){
      return;
    }

    const formValue =
      this.addressForm.value;

    const payload = {

      zipcode: formValue.cep,

      street: formValue.address_name,

      number: formValue.address_number,

      neighborhood:
        formValue.neighborhood,

      city_state: formValue.city,

      city_id: formValue.city_id,
    };

    this.submitAddress.emit(
      payload
    );
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
