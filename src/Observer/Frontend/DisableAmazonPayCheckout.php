<?php

declare(strict_types=1);

namespace MVenghaus\HyvaCheckoutAmazonPay\Observer\Frontend;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use MVenghaus\HyvaCheckoutAmazonPay\Model\AmazonPayCheckout;

class DisableAmazonPayCheckout implements ObserverInterface
{
    public function __construct(
        private readonly AmazonPayCheckout $amazonPayCheckout
    ) {
    }

    public function execute(Observer $observer)
    {
        $this->amazonPayCheckout->deactivateCheckout();
    }
}
