<?php

namespace CommunityBuilders\Omnipay\Quickstream\Message;

use Omnipay\Tests\TestCase;

class CreateCardRequestTest extends TestCase
{
    /** @var CreateCardRequest */
    protected $request;

    public function setUp()
    {
        $this->request = new CreateCardRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->setCard($this->getValidCard());
        $this->request->setTestMode(true);
    }

    public function testGetDataTruncatesCardHolderName()
    {
        $long_name = str_repeat("ab", 75);

        $this->request->getCard()->setName($long_name);
        self::assertSame(substr($long_name, 0, 120), $this->request->getData()['card.cardHolderName']);

        // Also make sure we can use shorter names without them being truncated.
        $this->request->getCard()->setName("Short Name");
        self::assertSame("Short Name", $this->request->getData()['card.cardHolderName']);
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('CreateCardSuccess.txt');

        /** @var Response $response */
        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());

        $this->assertSame('NSWLPQ-25640218', $response->getCustomerReference());
        $this->assertSame('Approved or completed successfully', $response->getMessage());
    }

    public function testSendFailure()
    {
        $this->setMockHttpResponse('CreateCardFailure.txt');

        /** @var Response $response */
        $response = $this->request->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getCustomerReference());
        $this->assertSame("Invalid card number (no such number)", $response->getMessage());
    }
}
