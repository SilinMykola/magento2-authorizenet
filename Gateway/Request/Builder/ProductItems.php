<?php

declare(strict_types=1);

namespace Silin\Authorizenet\Gateway\Request\Builder;

use Magento\Payment\Gateway\Data\PaymentDataObjectInterface;
use Magento\Payment\Gateway\Request\BuilderInterface;
use Magento\Sales\Api\Data\OrderItemInterface;

class ProductItems implements BuilderInterface
{
    /**
     * @param array $buildSubject
     * @return array[]
     */
    public function build(array $buildSubject): array
    {
        /** @var PaymentDataObjectInterface $paymentDataObject */
        $paymentDataObject = $buildSubject['payment'];
        $order = $paymentDataObject->getOrder();
        $items = [];

        /** @var OrderItemInterface $item */
        foreach ($order->getItems() as $key => $item) {
            $items['lineItem'][] = [
                'itemId' => (string) $item->getProductId(),
                'name' => substr($item->getName(), 0, 31),
                'description' => $item->getDescription() ? substr($item->getDescription(), 0, 255) : '',
                'quantity' => $item->getQtyOrdered(),
                'unitPrice' => $item->getPrice()
            ];
        }

        return [
            'lineItems' => $items
        ];
    }
}
