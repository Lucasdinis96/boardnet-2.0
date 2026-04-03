import { Routes } from '@angular/router';
import { SandboxComponent } from './features/sandbox/sandbox.component';
import { UserComponent } from './features/user/user.component';
import { authGuard } from './core/guards/auth-guard';
import { HomeComponent } from './features/home/home.component';

export const routes: Routes = [
   {
       path: 'home',
       component: HomeComponent
   },
   {
        path: 'user',
        canActivate: [authGuard], loadComponent: () => UserComponent
   }
];
