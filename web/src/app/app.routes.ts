import { Routes } from '@angular/router';
import { SandboxComponent } from './features/sandbox/sandbox.component';
import { UserComponent } from './features/user/user.component';
import { authGuard } from './core/guards/auth-guard';
import { HomeComponent } from './features/home/home.component';
import { RegisterComponent } from './features/auth/register/register.component';
import { VerifyEmailComponent } from './features/auth/verify-email/verify-email.component';

export const routes: Routes = [
   {
       path: 'home',
       component: HomeComponent
   },
   {
        path: 'user',
        canActivate: [authGuard], loadComponent: () => UserComponent
   },
   {
       path: 'register',
       component: RegisterComponent
   },
   {
        path: 'verifyEmail/:token',
        component: VerifyEmailComponent
   },
];
