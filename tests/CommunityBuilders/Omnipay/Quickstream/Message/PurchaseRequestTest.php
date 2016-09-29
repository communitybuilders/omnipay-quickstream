<?php

namespace CommunityBuilders\Omnipay\Quickstream\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
{
    const TEST_CUSTOMER_REFERENCE = "1234567";

    /** @var PurchaseRequest */
    protected $request;

    public function setUp()
    {
        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->setCustomerReference(self::TEST_CUSTOMER_REFERENCE);
        $this->request->setAmount(100.00);
        $this->request->setTestMode(true);
    }

    public function testNullAmountThrowsException()
    {
        $this->setExpectedException(InvalidRequestException::class, "The amount parameter is required");
        $this->request->setAmount(null);
        $this->request->getData();
    }

    public function testNegativeAmountThrowsException()
    {
        $this->setExpectedException(InvalidRequestException::class, "A negative amount is not allowed");
        $this->request->setAmount(-10.00);
        $this->request->getData();
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('PurchaseSuccess.txt');

        /** @var Response $response */
        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('350', $response->getTransactionReference());
        $this->assertNull($response->getCustomerReference());
        $this->assertSame('Honour with identification', $response->getMessage());
    }

    public function testSendFailure()
    {
        $this->setMockHttpResponse('PurchaseFailure.txt');

        /** @var Response $response */
        $response = $this->request->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('347', $response->getTransactionReference());
        $this->assertSame("Duplicate order number with different order type", $response->getMessage());
    }
}
