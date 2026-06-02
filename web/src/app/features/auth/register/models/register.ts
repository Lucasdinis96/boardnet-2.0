export interface RegisterRequest {
    name: string;
    birthdate: string;
    phone: string;
    cep: string;
    address_name: string;
    address_number: string;
    neighborhood: string;
    city_id: number;
    email: string;
    password: string;
    password_confirm: string;
}