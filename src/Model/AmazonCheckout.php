<?php

declare(strict_types=1);

namespace MVenghaus\HyvaCheckoutAmazonPay\Model;

use Magento\Checkout\Model\Session as CheckoutSession;

class AmazonCheckout
{
    public function __construct(
        private readonly CheckoutSession $checkoutSession,
    ) {
    }

    public function getAmazonCheckoutSessionId(): ?string
    {
        return $this->checkoutSession->getAmazonCheckoutSessionId();
    }

    public function isAmazonCheckout(): bool
    {
        return !empty($this->getAmazonCheckoutSessionId());
    }

    public function disableAmazonCheckout(): void
    {
        $this->checkoutSession->setAmazonCheckoutSessionId(null);
    }

    public function getAmazonCheckoutChangeUrl(): string
    {
        return 'https://payments.amazon.de/checkout?amazonCheckoutSessionId=' . $this->getAmazonCheckoutSessionId();
    }
}
