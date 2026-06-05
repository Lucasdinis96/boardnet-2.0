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
  private _disabled = false;
  userInfo: any;
  user: any;
  message: any;
  id: any;
  isDisabled = false;
  @Input() initialData: any;
  @Output() submitAddress = new EventEmitter<any>();
  @Input() set disabled(value: boolean) {
      this.isDisabled = value;
      this._disabled = value;
      if (!this.addressForm) {
        return;
      }
      this.toggleFormState();
    }

  private toggleFormState() {
    this._disabled ? this.addressForm.disable() : this.addressForm.enable();
  }

  ngOnInit(){
    this.initializeForm();
    this.toggleFormState();
    this.patchInitialData();
    this.getCities();
  }
  
  initializeForm(){
    this.addressForm = new FormGroup<any>({
      zipcode: new FormControl(null),
      street: new FormControl(null),
      number: new FormControl(null),
      neighborhood: new FormControl(null),
      city_state: new FormControl(null),
      city_id: new FormControl(null)
    })
  }

  patchInitialData(){

    if(!this.initialData){
      return;
    }

    this.addressForm.patchValue({
      zipcode: this.initialData.zipcode,
      street: this.initialData.street,
      number: this.initialData.number,
      neighborhood: this.initialData.neighborhood,
      city_id: this.initialData.city?.id,
      city_state: this.initialData.city ? `${this.initialData.city.name} - ${this.initialData.city.state}` : null
    });
  }

  submit(){
      if(this.addressForm.invalid){return;}

      const formValue = this.addressForm.value;
      const payload = {
        zipcode: formValue.zipcode,
        street: formValue.street,
        number: formValue.number,
        neighborhood: formValue.neighborhood,
        city_state: formValue.city_state,
        city_id: formValue.city_id,
      };

      this.submitAddress.emit(payload);
    }

    emitAddress() {
      this.submitAddress.emit(this.addressForm.getRawValue())
    }

  getCities(){
    this.cities$ = this.addressForm.controls['city_state'].valueChanges.pipe(
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
      city_state: city.name,
      city_id: city.id
    },
    { emitEvent: false }
  );
    this.isDropdownOpen = false;
  }
}
