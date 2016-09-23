<?php

namespace CommunityBuilders\Omnipay\Quickstream\Message;

class RefundRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate("transactionReference");

        return array(
            'order.type'                   => 'refund',
            'customer.orderNumber'         => $this->getTransactionId(), // The reference for THIS refund payment.
            'customer.originalOrderNumber' => $this->getTransactionReference(), // The reference for the payment that this payment is a refund for.
            'card.currency'                => $this->getCurrency(),
            'order.amount'                 => abs($this->getAmountInteger())
        );
    }
}
