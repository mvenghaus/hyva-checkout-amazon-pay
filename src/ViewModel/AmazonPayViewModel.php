<?php

declare(strict_types=1);

namespace MVenghaus\HyvaCheckoutAmazonPay\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\View\LayoutInterface;
use MVenghaus\HyvaCheckoutAmazonPay\Block\Shortcut;

class AmazonPayViewModel implements ArgumentInterface
{
    public function __construct(
        private readonly LayoutInterface $layout
    ) {
    }

    public function renderShortcut(): string
    {
        return $this->layout->createBlock(Shortcut::class)
            ->toHtml();
    }
}
