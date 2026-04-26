export interface RegisterRequest {
    name: string;
    birthdate: string;
    phone: string;
    cep: string;
    adress_name: string;
    adress_number: string;
    neighborhood: string;
    city_id: number;
    email: string;
    password: string;
    password_confirm: string;
}