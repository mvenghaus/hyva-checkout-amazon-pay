<?php

declare(strict_types=1);

namespace MVenghaus\HyvaCheckoutAmazonPay\Observer\Frontend;

use Amazon\Pay\Model\AmazonConfig;
use Magento\Catalog\Block\ShortcutButtons;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use MVenghaus\HyvaCheckoutAmazonPay\Block\Shortcut as ShortcutBlock;

class AddAmazonPayShortcut implements ObserverInterface
{
    public function __construct(
        private readonly AmazonConfig $amazonConfig
    ) {
    }

    public function execute(Observer $observer)
    {
        if (
            !$observer->getEvent()->getIsShoppingCart()
            || !$this->amazonConfig->isEnabled()
        ) {
            return;
        }

        /** @var ShortcutButtons $shortcutButtons */
        $shortcutButtons = $observer->getEvent()->getContainer();

        $shortcutBlock = $shortcutButtons->getLayout()
            ->createBlock(ShortcutBlock::class);

        $shortcutButtons->addShortcut($shortcutBlock);
    }
}
