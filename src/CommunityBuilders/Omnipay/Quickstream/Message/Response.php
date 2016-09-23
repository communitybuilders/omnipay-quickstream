<?php

namespace CommunityBuilders\Omnipay\Quickstream\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * Quickstream Response
 * This is the response class for all Quickstream requests.
 *
 * @see \CommunityBuilders\Omnipay\Quickstream\Gateway
 */
class Response extends AbstractResponse
{
    public function isSuccessful()
    {
        return $this->data[ 'response.summaryCode' ] === "0";
    }

    public function isRedirect()
    {
        return false;
    }

    public function getTransactionReference()
    {
        return $this->data[ 'response.orderNumber' ];
    }

    public function getMessage()
    {
        return $this->data[ 'response.text' ];
    }

    public function getResponseCode()
    {
        return $this->data[ 'response.responseCode' ];
    }

    /**
     * Get a customer reference for createCard requests.
     *
     * @return string|NULL
     */
    public function getCustomerReference()
    {
        if (empty($this->data[ 'response.customerReferenceNumber' ])) {
            return null;
        }

        return $this->data[ 'response.customerReferenceNumber' ];
    }
}
