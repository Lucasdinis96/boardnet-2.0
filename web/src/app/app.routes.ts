import { Routes } from '@angular/router';
import { UserComponent } from './features/user/user.component';
import { authGuard } from './core/guards/auth-guard';
import { HomeComponent } from './features/home/home.component';
import { RegisterComponent } from './features/auth/register/register.component';
import { VerifyEmailComponent } from './features/auth/verify-email/verify-email.component';
import { BoardgameComponent } from './features/boardgame/boardgame.component';
import { BoardgameDetailComponent } from './features/boardgame/pages/boardgame-detail/boardgame-detail.component';

export const routes: Routes = [
   {
       path: 'home',
       component: HomeComponent
   },
   {
        path: 'user',
        canActivate: [authGuard],
        loadComponent: () => UserComponent,
        loadChildren: () => import('./features/user/user.routes').then(m => m.user_routes),
   },
   {
       path: 'register',
       component: RegisterComponent
   },
   {
        path: 'verifyEmail/:token',
        component: VerifyEmailComponent
   },
   {
        path: 'boardgames',
        component: BoardgameComponent
   },
   {
        path: 'boardgame/:id',
        component: BoardgameDetailComponent
   }
];
