<?php

declare(strict_types=1);

namespace MVenghaus\HyvaCheckoutAmazonPay\Helper\Config;

use Magento\Framework\App\Helper\AbstractHelper;

class RendererConfig extends AbstractHelper
{
    public function getScriptAttributes(): array
    {
        return [];
    }
}
