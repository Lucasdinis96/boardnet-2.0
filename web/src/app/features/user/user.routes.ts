import { Routes } from "@angular/router";
import { UserEditComponent } from "./pages/user-edit/user-edit.component";
import { authGuard } from "../../core/guards/auth-guard";
import { UserComponent } from "./user.component";
import { UserCollectionComponent } from "./pages/user-collection/user-collection.component";
import { UserGeneralComponent } from "./components/user-general/user-general.component";
import { UserAdressComponent } from "./components/user-adress/user-adress.component";
import { UserSecurityComponent } from "./components/user-security/user-security.component";

export const user_routes: Routes = [
    {
        path: '',
        canActivate: [authGuard],
        children: [
            {path: 'edit', component: UserEditComponent,
                children: [
                    {path: 'general', component: UserGeneralComponent},
                    {path: 'adress', component: UserAdressComponent},
                    {path: 'security', component: UserSecurityComponent}
                ]
            },
            {path: 'collection', component: UserCollectionComponent}
        ]
    }
]