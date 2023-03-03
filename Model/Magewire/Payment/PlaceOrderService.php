<?php

declare(strict_types=1);

namespace MVenghaus\HyvaCheckoutAmazonPay\Model\Magewire\Payment;

use Amazon\Pay\Model\Adapter\AmazonPayAdapter;
use Hyva\Checkout\Model\Magewire\Payment\AbstractPlaceOrderService;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Quote\Api\CartManagementInterface;
use Magento\Quote\Model\Quote;

class PlaceOrderService extends AbstractPlaceOrderService
{
    public function __construct(
        private readonly CheckoutSession $checkoutSession,
        private readonly AmazonPayAdapter $amazonPayAdapter,
        CartManagementInterface $cartManagement
    ) {
        parent::__construct($cartManagement);
    }

    public function placeOrder(Quote $quote): int
    {
        $paymentIntent = AmazonPayAdapter::PAYMENT_INTENT_AUTHORIZE;

        $response = $this->amazonPayAdapter->updateCheckoutSession(
            $quote,
            $this->checkoutSession->getAmazonCheckoutSessionId(),
            $paymentIntent
        );

        return 1;
    }

    public function canRedirect(): bool
    {
        return true;
    }

    public function getRedirectUrl(Quote $quote, ?int $orderId = null): string
    {
        return 'https://payments.amazon.de/checkout/processing?amazonCheckoutSessionId=' . $this->checkoutSession->getAmazonCheckoutSessionId();
    }
}
