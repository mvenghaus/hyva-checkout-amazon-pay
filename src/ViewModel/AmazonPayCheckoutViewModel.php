<?php

declare(strict_types=1);

namespace MVenghaus\HyvaCheckoutAmazonPay\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use MVenghaus\HyvaCheckoutAmazonPay\Model\AmazonCheckout;

class AmazonPayCheckoutViewModel implements ArgumentInterface
{
    public function __construct(
        private readonly AmazonCheckout $amazonPayCheckout
    ) {
    }

    public function isAmazonPayCheckout(): bool
    {
        return $this->amazonPayCheckout->isAmazonCheckout();
    }
}
