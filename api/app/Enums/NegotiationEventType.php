<?php

namespace App\Enums;

enum NegotiationEventType: string {

    case Created = 'created';
    case PaymentPending = 'payment_pending';
    case PaymentApproved = 'payment_approved';
    case PaymentRejected = 'payment_rejected';
    case Reserved = 'reserved';
    case WaitingShipping = 'waiting_shipping';
    case Shipped = 'shipped';
    case Delivered = 'delivered';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
    case Expired = 'expired';
    case RefundRequested = 'refund_requested';
    case RefundApproved = 'refund_approved';
    case DisputeOpened = 'dispute_opened';

    public function label(): string {

        return match($this) {

            self::Created => 'Negociação criada',
            self::PaymentPending => 'Pagamento pendente',
            self::PaymentApproved => 'Pagamento aprovado',
            self::PaymentRejected => 'Pagamento recusado',
            self::Reserved => 'Itens reservados',
            self::WaitingShipping => 'Aguardando Envio',
            self::Shipped => 'Pedido enviado',
            self::Delivered => 'Pedido entregue',
            self::Completed => 'Negociação concluída',
            self::Cancelled => 'Negociação cancelada',
            self::Expired => 'Reserva expirada',
            self::RefundRequested => 'Reembolso solicitado',
            self::RefundApproved => 'Reembolso aprovado',
            self::DisputeOpened => 'Disputa aberta',
        };
    }
}