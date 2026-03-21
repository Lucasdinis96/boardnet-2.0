import { Routes } from '@angular/router';
import { SandboxComponent } from './features/sandbox/sandbox.component';
import { UserComponent } from './features/user/user.component';
import { authGuard } from './core/guards/auth-guard';

export const routes: Routes = [
   {
       path: '',
       component: SandboxComponent
   },
   {
        path: 'user',
        canActivate: [authGuard], loadComponent: () => UserComponent
   }
];
