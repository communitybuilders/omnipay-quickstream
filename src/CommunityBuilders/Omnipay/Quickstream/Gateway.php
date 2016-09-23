<?php

namespace CommunityBuilders\Omnipay\Quickstream;

use CommunityBuilders\Omnipay\Quickstream\Message\CreateCardRequest;
use CommunityBuilders\Omnipay\Quickstream\Message\PurchaseRequest;
use CommunityBuilders\Omnipay\Quickstream\Message\QueryRequest;
use CommunityBuilders\Omnipay\Quickstream\Message\RefundRequest;

use Omnipay\Common\AbstractGateway;

/**
 * Quickstream Direct XML Payments Gateway
 * This class forms the gateway class for Quickstream Direct XML requests.
 */
class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Quickstream';
    }

    public function getUsername()
    {
        return $this->getParameter("username");
    }

    public function setUsername($username)
    {
        return $this->setParameter("username", $username);
    }

    public function getPassword()
    {
        return $this->getParameter("password");
    }

    public function setPassword($password)
    {
        return $this->setParameter("password", $password);
    }

    /**
     * "getMerchant" would be more relevant, but we want to match
     * the eWay API, so we'll use the standard function name "getCustomerId".
     *
     * @return string
     */
    public function getCustomerId()
    {
        return $this->getParameter("customerId");
    }

    public function setCustomerId($customerId)
    {
        return $this->setParameter("customerId", $customerId);
    }

    public function getSSLCertificate()
    {
        return $this->getParameter("sslCertificate");
    }

    public function setSSLCertificate($ssl_certificate)
    {
        return $this->setParameter("sslCertificate", $ssl_certificate);
    }

    public function createCard(array $parameters = array())
    {
        return $this->createRequest(CreateCardRequest::class, $parameters);
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest(PurchaseRequest::class, $parameters);
    }

    public function query(array $parameters = array())
    {
        return $this->createRequest(QueryRequest::class, $parameters);
    }

    public function refund(array $parameters = array())
    {
        return $this->createRequest(RefundRequest::class, $parameters);
    }

    function authorize(array $options = array())
    {
        // TODO: Implement authorize() method.
    }

    function completeAuthorize(array $options = array())
    {
        // TODO: Implement completeAuthorize() method.
    }

    function capture(array $options = array())
    {
        // TODO: Implement capture() method.
    }

    function completePurchase(array $options = array())
    {
        // TODO: Implement completePurchase() method.
    }

    function void(array $options = array())
    {
        // TODO: Implement void() method.
    }

    function updateCard(array $options = array())
    {
        // TODO: Implement updateCard() method.
    }

    function deleteCard(array $options = array())
    {
        // TODO: Implement deleteCard() method.
    }
}
