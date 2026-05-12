import { CommonModule } from '@angular/common';
import { Component, inject, OnInit } from '@angular/core';
import { FormControl, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { debounceTime, distinctUntilChanged, Observable, of, switchMap } from 'rxjs';
import { RegisterService } from '../../../auth/register/register.service';
import { CityService } from '../../../../core/services/city.service';
import { RegisterFormType } from '../../../auth/register/types/register-form.type';
import { RegisterRequest } from '../../../auth/register/models/register';
import { AuthService } from '../../../../core/services/auth.service';
import { UserService } from '../../user.service';
import { RouterLink, RouterModule } from '@angular/router';


@Component({
  selector: 'app-user-edit',
  imports: [CommonModule, ReactiveFormsModule, RouterLink, RouterModule],
  templateUrl: './user-edit.component.html',
  styleUrl: './user-edit.component.scss',
})
export class UserEditComponent {}
