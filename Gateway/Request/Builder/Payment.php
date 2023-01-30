<?php

declare(strict_types=1);

namespace Silin\Authorizenet\Gateway\Request\Builder;

use Magento\Payment\Gateway\Data\PaymentDataObjectInterface;
use Magento\Payment\Gateway\Request\BuilderInterface;
use Magento\Payment\Model\InfoInterface;
use Magento\Sales\Model\Order\Payment as OrderPayment;
use Silin\Authorizenet\Observer\DataAssignObserver;

class Payment implements BuilderInterface
{

    public function build(array $buildSubject)
    {
        /** @var PaymentDataObjectInterface $paymentDataObject */
        $paymentDataObject = $buildSubject['payment'];

        /** @var  InfoInterface|OrderPayment $payment */
        $payment = $paymentDataObject->getPayment();

        return [
            'payment' => [
                'creditCard' => [
                    'cardNumber' => $payment->getData(DataAssignObserver::CC_NUMBER),
                    'expirationDate' => $this->getCardExpirationDate($payment),
                    'cardCode' => $payment->getData(DataAssignObserver::CC_CID)
                ]
            ]
        ];
    }

    /**
     * @param InfoInterface|OrderPayment $payment
     * @return string
     */
    private function getCardExpirationDate(InfoInterface|OrderPayment $payment): string
    {
        return sprintf(
            '%s-%s',
            $payment->getData(DataAssignObserver::CC_EXP_YEAR),
            $payment->getData(DataAssignObserver::CC_EXP_MONTH)
        );
    }
}
