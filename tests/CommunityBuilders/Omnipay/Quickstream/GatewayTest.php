<?php

namespace CommunityBuilders\Omnipay\Quickstream;

use CommunityBuilders\Omnipay\Quickstream\Message\CreateCardRequest;
use CommunityBuilders\Omnipay\Quickstream\Message\PurchaseRequest;
use CommunityBuilders\Omnipay\Quickstream\Message\RefundRequest;
use Omnipay\Common\CreditCard;
use Omnipay\Tests\TestCase;

/**
 * Extends the eWAY Legacy Direct XML Payments Gateway
 * Allows creating tokens for credit cards and using the tokens to make payments.
 */
class GatewayTest extends TestCase
{
    /** @var Gateway */
    protected $gateway;

    public function setUp()
    {
        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setTestMode(true);
    }

    public function testCreateCard()
    {
        $card = new CreditCard([
            "number" => "4444333322221111"
        ]);

        $request = $this->gateway->createCard(["card" => $card]);

        self::assertInstanceOf(CreateCardRequest::class, $request);
        self::assertSame("4444333322221111", $request->getCard()->getNumber());
    }

    public function testPurchase()
    {
        $request = $this->gateway->purchase(['amount' => '10.00']);

        self::assertInstanceOf(PurchaseRequest::class, $request);
        self::assertSame("10.00", $request->getAmount());
    }

    public function testRefund()
    {
        /** @var RefundRequest $request */
        $request = $this->gateway->refund([
            "transactionId" => 123
        ]);

        self::assertInstanceOf(RefundRequest::class, $request);
        self::assertSame(123, $request->getTransactionId());
    }
}
