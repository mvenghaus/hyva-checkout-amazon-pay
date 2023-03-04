<?php

declare(strict_types=1);

namespace MVenghaus\HyvaCheckoutAmazonPay\Magewire;

use Magewirephp\Magewire\Component;
use MVenghaus\HyvaCheckoutAmazonPay\Model\AmazonPayCheckout;

class Toolbar extends Component
{
    public function __construct(
        private readonly AmazonPayCheckout $amazonPayCheckout
    ) {
    }

    public function backToStandard(): void
    {
        $this->amazonPayCheckout->deactivateCheckout();

        $this->redirect('checkout');
    }

    public function changeAmazonInformation(): void
    {
        $this->redirect($this->amazonPayCheckout->getCheckoutChangeUrl());
    }
}
