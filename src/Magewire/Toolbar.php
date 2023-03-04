<?php

declare(strict_types=1);

namespace MVenghaus\HyvaCheckoutAmazonPay\Magewire;

use Magewirephp\Magewire\Component;
use MVenghaus\HyvaCheckoutAmazonPay\Model\AmazonCheckout;

class Toolbar extends Component
{
    public function __construct(
        private readonly AmazonCheckout $amazonPayCheckout
    ) {
    }

    public function backToStandard(): void
    {
        $this->amazonPayCheckout->disableAmazonCheckout();

        $this->redirect('checkout');
    }

    public function changeAmazonInformation(): void
    {
        $this->redirect($this->amazonPayCheckout->getAmazonCheckoutChangeUrl());
    }
}
