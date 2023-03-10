<?php

declare(strict_types=1);

namespace MVenghaus\HyvaCheckoutAmazonPay\Plugin\Hyva\Checkout\ViewModel\Checkout\Payment;

use Amazon\Pay\Gateway\Config\Config;
use Hyva\Checkout\ViewModel\Checkout\Payment\Method;
use MVenghaus\HyvaCheckoutAmazonPay\Model\AmazonPayCheckout;

class MethodPlugin
{
    public function __construct(
        private readonly AmazonPayCheckout $amazonPayCheckout
    ) {
    }

    public function afterGetList(Method $subject, array|null $result): ?array
    {
        if ($result === null) {
            return null;
        }

        if ($this->amazonPayCheckout->isCheckoutActive()) {
            return array_filter($result, fn($payment) => $payment->getCode() === Config::CODE);
        }

        return array_filter($result, fn($payment) => $payment->getCode() !== Config::CODE);
    }
}
