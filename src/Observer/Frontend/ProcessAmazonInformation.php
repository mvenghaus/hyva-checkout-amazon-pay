<?php

declare(strict_types=1);

namespace MVenghaus\HyvaCheckoutAmazonPay\Observer\Frontend;

use Amazon\Pay\Api\CheckoutSessionManagementInterface as AmazonCheckoutSessionManagementInterface;
use Amazon\Pay\Gateway\Config\Config;
use Hyva\Checkout\Magewire\Checkout\AddressView\ShippingDetails\AddressList;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Customer\Api\AddressRepositoryInterface as CustomerAddressRepositoryInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\UrlInterface;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\QuoteRepository;
use MVenghaus\HyvaCheckoutAmazonPay\Model\AddressManagement;
use MVenghaus\HyvaCheckoutAmazonPay\Model\AmazonPayCheckout;

class ProcessAmazonInformation implements ObserverInterface
{
    public function __construct(
        private readonly RequestInterface $request,
        private readonly UrlInterface $url,
        private readonly AmazonPayCheckout $amazonPayCheckout,
        private readonly CheckoutSession $checkoutSession,
        private readonly CustomerAddressRepositoryInterface $customerAddressRepository,
        private readonly QuoteRepository $quoteRepository,
        private readonly AddressList $addressList,
        private readonly AddressManagement $addressManagement,
        private readonly AmazonCheckoutSessionManagementInterface $amazonCheckoutSessionManagement
    ) {
    }

    public function execute(Observer $observer)
    {
        $amazonCheckoutSessionId = $this->request->getParam('amazonCheckoutSessionId');
        if (!empty($amazonCheckoutSessionId)) {
            $quote = $this->checkoutSession->getQuote();

            $this->amazonPayCheckout->setCheckoutSessionId($amazonCheckoutSessionId);

            $this->processAddresses($quote, $amazonCheckoutSessionId);
            $this->processPayment($quote);

            $this->quoteRepository->save($quote);
            $quote->collectTotals();

            /** @var \Hyva\Checkout\Controller\Index\Index $controllerAction */
            $controllerAction = $observer->getData('controller_action');
            $controllerAction->getResponse()->setRedirect($this->url->getUrl('checkout'));
        }
    }

    private function processAddresses(Quote $quote, string $amazonCheckoutSessionId): void
    {
        $customer = $quote->getCustomer();
        $amazonCustomerAddress = $this->addressManagement->createCustomerAddressFromAmazonData(
            $customer,
            current($this->amazonCheckoutSessionManagement->getShippingAddress($amazonCheckoutSessionId))
        );

        $customerAddress = $this->addressManagement->searchCustomerAddress($customer, $amazonCustomerAddress);
        if (!$customerAddress) {
            $customerAddress = $this->customerAddressRepository->save($amazonCustomerAddress);
        }

        // !? add address manually, else QuoteAddressValidator will fail
        $customer->setAddresses([
            ...$customer->getAddresses(),
            $customerAddress
        ]);

        $this->addressList->activateAddress((string)$customerAddress->getId());
    }

    private function processPayment(Quote $quote): void
    {
        $quote
            ->getPayment()
            ->setQuote($quote)
            ->setMethod(Config::CODE)
            ->getMethodInstance();
    }
}
