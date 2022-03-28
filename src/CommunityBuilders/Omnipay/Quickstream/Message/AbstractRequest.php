<?php

namespace CommunityBuilders\Omnipay\Quickstream\Message;

/**
 * Quickstream Abstract Request
 */
abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $live_endpoint = "https://ccapi.client.qvalent.com/post/CreditCardAPIReceiver";
    protected $test_endpoint = "https://ccapi.client.support.qvalent.com/post/CreditCardAPIReceiver";

    /* Todo: find out what the following URL is for: https://ccapi.client.qvalent.com/payway/ccapi
        It returns a very similar response, except it is delimited by ampersands (&), not newlines, which
        would allow us to use the parse_str method to easily parse the response.
    */

    public function sendData($data)
    {
        // Add our customer details to our POST data array.
        $data[ "customer.username" ] = $this->getUsername();
        $data[ "customer.password" ] = $this->getPassword();
        $data[ "customer.merchant" ] = $this->getCustomerId();

        // Also need a message.end parameter for some reason.
        $data[ "message.end" ] = '';

        // Create a request.
        $headers = ['Content-Type' => 'application/x-www-form-urlencoded'];
        $http_response = $this->httpClient->request('POST', $this->getEndpoint(), $headers, http_build_query($data));

        $body = $http_response->getBody()->getContents();

        return $this->response = new Response($this, $this->_parseResponseBody($body));
    }

    private function _parseResponseBody($body)
    {
        $body_parts = explode("\r\n", $body);

        $return_array = array();
        foreach ($body_parts as $body_part) {
            if (strpos($body_part, "=") !== false) {
                list($key, $value) = explode("=", $body_part);
                $return_array[ $key ] = $value;
            }
        }

        return $return_array;
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

    public function getCustomerReference()
    {
        return $this->getParameter("customerReference");
    }

    public function setCustomerReference($customer_reference)
    {
        return $this->setParameter("customerReference", $customer_reference);
    }

    public function getSSLCertificate()
    {
        return $this->getParameter("sslCertificate");
    }

    public function setSSLCertificate($ssl_certificate)
    {
        return $this->setParameter("sslCertificate", $ssl_certificate);
    }

    public function getEndpoint()
    {
        return $this->getTestMode() ? $this->test_endpoint : $this->live_endpoint;
    }
}
