<?php

declare(strict_types=1);

namespace MVenghaus\HyvaCheckoutAmazonPay\Observer\Frontend;

use Amazon\Pay\Api\CheckoutSessionManagementInterface as AmazonCheckoutSessionManagementInterface;
use Amazon\Pay\Gateway\Config\Config;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class AdoptAmazonInformation implements ObserverInterface
{
    public function __construct(
        private readonly RequestInterface $request,
        private readonly CheckoutSession $checkoutSession,
        private readonly AmazonCheckoutSessionManagementInterface $amazonCheckoutSessionManagement
    ) {
    }

    public function execute(Observer $observer)
    {
        $quote = $this->checkoutSession->getQuote();

        $amazonCheckoutSessionId = $this->request->getParam('amazonCheckoutSessionId');
        if (!empty($amazonCheckoutSessionId)) {
            $this->checkoutSession->setAmazonCheckoutSessionId($amazonCheckoutSessionId);

            $amazonShippingAddress = $this->amazonCheckoutSessionManagement->getShippingAddress($amazonCheckoutSessionId);
            $quote->getShippingAddress()->addData(current($amazonShippingAddress));
            $quote->getBillingAddress()->addData(current($amazonShippingAddress));
            $quote
                ->getPayment()
                ->setQuote($quote)
                ->setMethod(Config::CODE)
                ->getMethodInstance();

            $quote->save()->collectTotals();

            header('Location: /checkout/');
            exit;
        }
    }
}
