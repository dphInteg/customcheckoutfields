<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace DphInteg\CustomCheckoutFields\Plugin\Checkout\Model;

class ShippingInformationManagement
{
    /**
     * @param \Magento\Checkout\Model\ShippingInformationManagement $subject
     * @param $cartId
     * @param \Magento\Checkout\Api\Data\ShippingInformationInterface $addressInformation
     */
    public function beforeSaveAddressInformation(
        \Magento\Checkout\Model\ShippingInformationManagement $subject,
        $cartId,
        \Magento\Checkout\Api\Data\ShippingInformationInterface $addressInformation
    ) {
        $shippingAddress = $addressInformation->getShippingAddress();
        $shippingExtensionAttributes = $shippingAddress->getExtensionAttributes();
        
        if (!empty($shippingExtensionAttributes)) {
            $brgy = $shippingExtensionAttributes->getBarangay();
            if (!empty($brgy)) {
                $shippingAddress->setBarangay($brgy);
                
                $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                $quote = $objectManager->get('Magento\Quote\Model\QuoteRepository');
                $quote = $quote->getActive($cartId);
            
                $shippingAdd = $quote->getShippingAddress();
                $billingAdd = $quote->getBillingAddress();
        
                $shippingAdd->setBarangay($brgy);
                $billingAdd->setBarangay($brgy);
            }
        }
    }
}