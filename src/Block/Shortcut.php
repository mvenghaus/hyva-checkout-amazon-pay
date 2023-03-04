<?php

declare(strict_types=1);

namespace MVenghaus\HyvaCheckoutAmazonPay\Block;

use Amazon\Pay\Api\CheckoutSessionManagementInterface;
use Magento\Catalog\Block\ShortcutInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Shortcut extends Template implements ShortcutInterface
{
    protected $_template = 'MVenghaus_HyvaCheckoutAmazonPay::shortcut.phtml';

    private CheckoutSessionManagementInterface $checkoutSessionManagement;

    public function __construct(
        Context $context,
        CheckoutSessionManagementInterface $checkoutSessionManagement,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->checkoutSessionManagement = $checkoutSessionManagement;
    }

    public function getAlias()
    {
        return 'amazon_pay';
    }

    public function getCheckoutSessionManagement(): CheckoutSessionManagementInterface
    {
        return $this->checkoutSessionManagement;
    }
}
