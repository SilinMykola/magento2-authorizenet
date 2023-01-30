<?php

declare(strict_types=1);

namespace Silin\Authorizenet\Observer;

use Magento\Framework\Event\Observer;
use Magento\Payment\Observer\AbstractDataAssignObserver;
use Magento\Quote\Api\Data\PaymentInterface;
use Magento\Quote\Model\Quote\Payment;

class DataAssignObserver extends AbstractDataAssignObserver
{
    public const CC_NUMBER = 'cc_number';
    public const CC_TYPE_4 = 'cc_last_4';
    public const CC_TYPE = 'cc_type';
    public const CC_EXP_MONTH = 'cc_exp_month';
    public const CC_EXP_YEAR = 'cc_exp_year';
    public const CC_CID = 'cc_cid';

    private array $paymentFields = [
       self::CC_NUMBER => 'cc_number',
       self::CC_TYPE => 'cc_type',
       self::CC_EXP_MONTH => 'cc_exp_month',
        self::CC_EXP_YEAR => 'cc_exp_year',
        self::CC_CID => 'cc_cid'
    ];

    /**
     * @param Observer $observer
     *
     * @return void
     */
    public function execute(Observer $observer): void
    {
        $data = $this->readDataArgument($observer);
        $additionalData = $data->getData(PaymentInterface::KEY_ADDITIONAL_DATA);

        if (!is_array($additionalData) || count($additionalData) === 0) {
            return;
        }

        /** @var Payment $paymentInfo */
        $paymentInfo = $this->readPaymentModelArgument($observer);

        foreach ($this->paymentFields as $field => $formField) {
            if ($additionalData[$formField] !== null) {
                $paymentInfo->setData($field, $additionalData[$formField]);
            }
        }
    }
}
