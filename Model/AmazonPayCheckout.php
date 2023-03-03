<?php

declare(strict_types=1);

namespace MVenghaus\HyvaCheckoutAmazonPay\Model;

use Magento\Checkout\Model\Session as CheckoutSession;

class AmazonPayCheckout
{
    public function __construct(
        private readonly CheckoutSession $checkoutSession
    ) {
    }

    public function isAmazonPayCheckout(): bool
    {
        return !empty($this->checkoutSession->getAmazonCheckoutSessionId());
    }

    public function disableAmazonPayCheckout(): void
    {
        $this->checkoutSession->setAmazonCheckoutSessionId(null);
    }
}
