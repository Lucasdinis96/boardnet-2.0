import { Routes } from "@angular/router";
import { UserEditComponent } from "./pages/user-edit/user-edit.component";
import { authGuard } from "../../core/guards/auth-guard";
import { UserComponent } from "./user.component";
import { UserCollectionComponent } from "./pages/user-collection/user-collection.component";
import { UserGeneralComponent } from "./pages/user-edit/components/user-general/user-general.component";
import { UserSecurityComponent } from "./pages/user-edit/components/user-security/user-security.component";
import { UserAdressComponent } from "./pages/user-edit/components/user-adress/user-adress.component";


export const user_routes: Routes = [
    {
        path: '',
        canActivate: [authGuard],
        children: [
            {path: 'edit', component: UserEditComponent,
                children: [
                    {path: '', redirectTo: 'general', pathMatch: 'full' },
                    {path: 'general', component: UserGeneralComponent},
                    {path: 'adress', component: UserAdressComponent},
                    {path: 'security', component: UserSecurityComponent}
                ]
            },
            {path: 'collection', component: UserCollectionComponent}
        ]
    }
]