<?php

declare(strict_types=1);

namespace MVenghaus\HyvaCheckoutAmazonPay\Model;

use Magento\Customer\Api\Data\AddressInterfaceFactory as CustomerAddressInterfaceFactory;
use Magento\Customer\Model\Data\Address as CustomerAddress;
use Magento\Customer\Model\Data\Customer;

class AddressManagement
{
    public function __construct(
        private readonly CustomerAddressInterfaceFactory $customerAddressFactory
    ) {
    }

    public function createCustomerAddressFromAmazonData(Customer $customer, array $amazonData): CustomerAddress
    {
        return $this->customerAddressFactory->create()
            ->setCustomerId($customer->getId())
            ->setCompany($amazonData['company'] ?? '')
            ->setFirstname($amazonData['firstname'] ?? '')
            ->setLastname($amazonData['lastname'] ?? '')
            ->setStreet($amazonData['street'] ?? '')
            ->setPostcode($amazonData['postcode'] ?? '')
            ->setCity($amazonData['city'] ?? '')
            ->setCountryId($amazonData['country_id'] ?? '')
            ->setTelephone($amazonData['telephone'] ?? '')
            ->setRegionId((int)($amazonData['region_id'] ?? ''));
    }

    public function searchCustomerAddress(Customer $customer, CustomerAddress $address): ?CustomerAddress
    {
        foreach ($customer->getAddresses() as $customerAddress) {
            if ((string)$customerAddress->getFirstname() === (string)$address->getFirstname() &&
                (string)$customerAddress->getLastname() === (string)$address->getLastname() &&
                implode('', $customerAddress->getStreet()) === implode('', $address->getStreet()) &&
                (string)$customerAddress->getPostcode() === (string)$address->getPostcode() &&
                (string)$customerAddress->getCity() === (string)$address->getCity() &&
                (string)$customerAddress->getCountryId() === (string)$address->getCountryId() &&
                (string)$customerAddress->getCompany() === (string)$address->getCompany() &&
                (string)$customerAddress->getTelephone() === (string)$address->getTelephone()
            ) {
                return $customerAddress;
            }
        }

        return null;
    }
}
