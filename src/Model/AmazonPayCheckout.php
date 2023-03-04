<?php

declare(strict_types=1);

namespace MVenghaus\HyvaCheckoutAmazonPay\Model;

use Amazon\Pay\Api\CheckoutSessionManagementInterface as AmazonCheckoutSessionManagementInterface;
use Amazon\Pay\Model\AmazonConfig;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Quote\Model\QuoteRepository;

class AmazonPayCheckout
{
    public function __construct(
        private readonly AmazonConfig $amazonConfig,
        private readonly CheckoutSession $checkoutSession,
        private readonly QuoteRepository $quoteRepository,
        private readonly AmazonCheckoutSessionManagementInterface $amazonCheckoutSessionManagement
    ) {
    }

    public function isEnabled(): bool
    {
        return $this->amazonConfig->isEnabled();
    }

    public function getCheckoutSessionConfig(): array
    {
        return $this->amazonCheckoutSessionManagement->getConfig();
    }

    public function setCheckoutSessionId(string $checkoutSessionId): void
    {
        $this->checkoutSession->setAmazonPayCheckoutSessionId($checkoutSessionId);
    }

    public function getCheckoutSessionId(): ?string
    {
        return $this->checkoutSession->getAmazonPayCheckoutSessionId();
    }

    public function isCheckoutActive(): bool
    {
        return !empty($this->getCheckoutSessionId());
    }

    public function deactivateCheckout(): void
    {
        $this->checkoutSession->setAmazonPayCheckoutSessionId(null);

        $quote = $this->checkoutSession->getQuote();
        $quote->getPayment()->setMethod('');
        $this->quoteRepository->save($quote);
    }

    public function getCheckoutChangeUrl(): string
    {
        return 'https://payments.amazon.de/checkout?amazonCheckoutSessionId=' . $this->getCheckoutSessionId();
    }
}
