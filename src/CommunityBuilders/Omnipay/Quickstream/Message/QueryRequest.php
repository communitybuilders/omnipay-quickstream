<?php

namespace CommunityBuilders\Omnipay\Quickstream\Message;

class QueryRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate("transactionReference");

        return array(
            'order.type'           => 'query',
            'customer.orderNumber' => $this->getTransactionReference()
        );
    }
}
