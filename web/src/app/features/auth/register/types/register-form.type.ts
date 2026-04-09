import { FormControl } from "@angular/forms";

export type RegisterFormType = {
  name: FormControl<string | null>;
  birthdate: FormControl<string | null>;
  phone: FormControl<string | null>;
  cep: FormControl<string | null>;
  adress_name: FormControl<string | null>;
  adress_number: FormControl<string | null>;
  neighborhood: FormControl<string | null>;
  city: FormControl<string | null>;
  city_id: FormControl<number | null>;
  email: FormControl<string | null>;
  password: FormControl<string | null>;
  password_confirm: FormControl<string | null>;
};