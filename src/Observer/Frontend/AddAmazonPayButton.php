<?php

declare(strict_types=1);

namespace MVenghaus\HyvaCheckoutAmazonPay\Observer\Frontend;

use Magento\Catalog\Block\ShortcutButtons;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use MVenghaus\HyvaCheckoutAmazonPay\Block\PayButton;

class AddAmazonPayButton implements ObserverInterface
{
    public function execute(Observer $observer)
    {
        if (!$observer->getEvent()->getIsShoppingCart()) {
            return;
        }

        /** @var ShortcutButtons $shortcutButtons */
        $shortcutButtons = $observer->getEvent()->getContainer();

        $amazonPayButton = $shortcutButtons->getLayout()
            ->createBlock(PayButton::class);

        $shortcutButtons->addShortcut($amazonPayButton);
    }
}
