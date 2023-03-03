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

    public function afterGetList(Method $subject, array|null $result): array
    {
        if (!$this->amazonPayCheckout->isAmazonPayCheckout() || !is_array($result)) {
            return $result;
        }

        return array_filter($result, fn($payment) => $payment->getCode() === Config::CODE);
    }
}
