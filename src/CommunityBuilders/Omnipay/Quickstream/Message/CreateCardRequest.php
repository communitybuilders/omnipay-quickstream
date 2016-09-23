<?php

namespace CommunityBuilders\Omnipay\Quickstream\Message;

class CreateCardRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate("card");

        $card = $this->getCard();
        $card->validate();

        return array(
            "order.type"                       => "registerAccount",
            "card.cardHolderName"              => (strlen($card->getName()) > 120 ? substr($card->getName(), 0, 120) : $card->getName()), //truncate card name to avoid error. Ticket #7097
            "card.PAN"                         => $card->getNumber(),
            "card.expiryYear"                  => $card->getExpiryDate("y"),
            "card.expiryMonth"                 => $card->getExpiryMonth(),
            "customer.customerReferenceNumber" => $this->getCustomerReference()
        );
    }
}
