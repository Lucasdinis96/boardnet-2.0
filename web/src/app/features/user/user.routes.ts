import { Routes } from "@angular/router";
import { UserEditComponent } from "./pages/user-edit/user-edit.component";
import { authGuard } from "../../core/guards/auth-guard";
import { UserComponent } from "./user.component";
import { UserCollectionComponent } from "./pages/user-collection/user-collection.component";
import { UserGeneralComponent } from "./pages/user-edit/components/user-general/user-general.component";
import { UserSecurityComponent } from "./pages/user-edit/components/user-security/user-security.component";
import { UserAddressComponent } from "./pages/user-edit/components/user-address/user-address.component";
import { UserTradesComponent } from "./pages/user-trades/user-trades.component";
import { UserTradeEditComponent } from "./pages/user-trades/pages/user-trade-edit/user-trade-edit.component";
import { UserTradeCreateComponent } from "./pages/user-trades/pages/user-trade-create/user-trade-create.component";
import { UserNegotiationComponent } from "./pages/user-negotiation/user-negotiation.component";
import { UserPurchaseComponent } from "./pages/user-negotiation/components/user-purchase/user-purchase.component";
import { UserSaleComponent } from "./pages/user-negotiation/components/user-sale/user-sale.component";
import { UserFinancesComponent } from "./pages/user-finances/user-finances.component";
import { UserPaymentsComponent } from "./pages/user-finances/components/user-payments/user-payments.component";
import { UserReceivablesComponent } from "./pages/user-finances/components/user-receivables/user-receivables.component";
import { UserAvatarComponent } from "./pages/user-edit/components/user-avatar/user-avatar.component";


export const user_routes: Routes = [
    {
        path: '',
        canActivate: [authGuard],
        children: [
            {path:'', redirectTo: 'trades', pathMatch: 'full'},
            {path: 'edit', component: UserEditComponent,
                children: [
                    {path: '', redirectTo: 'general', pathMatch: 'full' },
                    {path: 'general', component: UserGeneralComponent},
                    {path: 'address', component: UserAddressComponent},
                    {path: 'security', component: UserSecurityComponent},
                    {path: 'avatar', component: UserAvatarComponent},
                ]
            },
            {path: 'collection', component: UserCollectionComponent},
            {path: 'trades',
                children: [
                    {path: '', component: UserTradesComponent},
                    {path: 'create', component: UserTradeCreateComponent},
                    {path: 'edit/:id', component: UserTradeEditComponent}
                ]
            },
            {path: 'negotiation', component: UserNegotiationComponent,
                children : [
                    {path: '', redirectTo: 'purchases', pathMatch: 'full'},
                    {path: 'purchases', component: UserPurchaseComponent},
                    {path: 'sales', component: UserSaleComponent}
                ]
            },
            {path: 'finances', component: UserFinancesComponent,
                children : [
                    {path: '', redirectTo: 'payments', pathMatch: 'full'},
                    {path: 'payments', component: UserPaymentsComponent},
                    {path: 'receivables', component: UserReceivablesComponent},
                ]
            }

        ]
    }
]