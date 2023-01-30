<?php

declare(strict_types=1);

namespace Silin\Authorizenet\Gateway\Request\Builder;

use Magento\Payment\Gateway\Data\AddressAdapterInterface;
use Magento\Payment\Gateway\Data\PaymentDataObjectInterface;
use Magento\Payment\Gateway\Request\BuilderInterface;

class Address implements BuilderInterface
{
    public function build(array $buildSubject): array
    {
        /** @var PaymentDataObjectInterface $paymentDataObject */
        $paymentDataObject = $buildSubject['payment'];

        $order = $paymentDataObject->getOrder();

        $billingAddress = $order->getBillingAddress();
        $shippingAddress = $order->getShippingAddress();
        $result = [];

        if ($billingAddress instanceof AddressAdapterInterface) {
            $result['billTo'] = $this->getFormattedAddress($billingAddress);
        }

        if ($shippingAddress instanceof AddressAdapterInterface) {
            $result['shipTo'] = $this->getFormattedAddress($shippingAddress);
        }

        return $result;
    }

    /**
     * @param AddressAdapterInterface $address
     * @return array
     */
    private function getFormattedAddress(AddressAdapterInterface $address): array
    {
        return [
            'firstName' => $address->getFirstName(),
            'lastName' => $address->getLastname(),
            'company' => $address->getCompany() ?: '',
            'address' => $address->getStreetLine1() . $address->getStreetLine2(),
            'city' => $address->getCity(),
            'state' => $address->getRegionCode(),
            'zip' => $address->getPostcode(),
            'country' => $address->getCountryId()
        ];
    }
}
