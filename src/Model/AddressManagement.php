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
            ->setRegionId((int)($amazonData['region_id'] ?? ''))
            ->setCountryId($amazonData['country_id'] ?? '')
            ->setTelephone($amazonData['telephone'] ?? '');

    }

    /**
     * Better than before but I don't like ;)
     */
    public function searchCustomerAddress(Customer $customer, CustomerAddress $address): ?CustomerAddress
    {
        foreach ($customer->getAddresses() as $customerAddress) {
            if ($this->createCompareAddress($customerAddress) === $this->createCompareAddress($address)) {
                return $customerAddress;
            }
        }

        return null;
    }

    private function createCompareAddress(CustomerAddress $address): array
    {
        return [
            'firstname' => (string)$address->getFirstname(),
            'lastname' => (string)$address->getLastname(),
            'street' => implode('', $address->getStreet()),
            'postcode' => (string)$address->getPostcode(),
            'city' => (string)$address->getCity(),
            'region_id' => (string)$address->getRegionId(),
            'country_id' => (string)$address->getCountryId(),
            'company' => (string)$address->getCompany(),
            'telephone' => (string)$address->getTelephone()
        ];
    }
}
