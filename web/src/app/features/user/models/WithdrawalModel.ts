export interface Withdrawal {
    id: number;
    amount: string;
    status: string;
    requested_at: string;
    paid_at: string;
    created_at: string;
    negotiation_id: number;
}