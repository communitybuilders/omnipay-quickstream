<?php

namespace CommunityBuilders\Omnipay\Quickstream\Message;

class PurchaseRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate("amount");

        if( $this->getToken() ) {
            $customer_reference = $this->getToken();
        }else {
            $customer_reference = $this->getCustomerReference();
        }

        return array(
            'order.type'                       => 'capture',
            'customer.orderNumber'             => $this->getTransactionReference(),
            'customer.customerReferenceNumber' => $customer_reference,
            'card.currency'                    => $this->getCurrency(),
            'card.CVN'                         => $this->getCvv(),
            'order.amount'                     => $this->getAmountInteger()
        );
    }

    public function setCvv($cvv)
    {
        return $this->setParameter('cvv', $cvv);
    }

    public function getCvv()
    {
        return $this->getParameter('cvv');
    }
}
