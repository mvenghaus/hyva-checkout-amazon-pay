<?php

declare(strict_types=1);

namespace MVenghaus\HyvaCheckoutAmazonPay\Observer\Frontend;

use Amazon\Pay\Api\CheckoutSessionManagementInterface as AmazonCheckoutSessionManagementInterface;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class SetShippingAddressFromAmazon implements ObserverInterface
{
    public function __construct(
        private readonly RequestInterface $request,
        private readonly CheckoutSession $checkoutSession,
        private readonly AmazonCheckoutSessionManagementInterface $amazonCheckoutSessionManagement
    ) {
    }

    public function execute(Observer $observer)
    {
        $amazonCheckoutSessionId = $this->request->getParam('amazonCheckoutSessionId');
        if (!empty($amazonCheckoutSessionId)) {
            $this->checkoutSession->setAmazonCheckoutSessionId($amazonCheckoutSessionId);

            $quote = $this->checkoutSession->getQuote();
            $amazonShippingAddress = $this->amazonCheckoutSessionManagement->getShippingAddress($amazonCheckoutSessionId);
            $quote->getShippingAddress()->addData(current($amazonShippingAddress));
            $quote->getBillingAddress()->addData(current($amazonShippingAddress));
            $quote->save()->collectTotals();

            header('Location: /checkout/');
            exit;
        }

    }
}
