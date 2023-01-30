<?php

declare(strict_types=1);

namespace Silin\Authorizenet\Gateway\Response;

use Magento\Payment\Gateway\Data\PaymentDataObjectInterface;
use Magento\Payment\Gateway\Response\HandlerInterface;

/**
 * Adds the payment information from the response to the payment object
 *
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class PaymentDetailsHandler implements HandlerInterface
{
    /**
     * @var array|string[]
     */
    private array $additionalInformation = [
        ResponseFields::AUTH_CODE => 'auth_code',
        ResponseFields::AVS_RESULT_CODE => 'avs_result_code',
        ResponseFields::CVV_RESULT_CODE => 'cv_result_code',
        ResponseFields::CAVV_RESULT_CODE => 'cavv_result_code',
        ResponseFields::ACCOUNT_NUMBER => 'account_number',
        ResponseFields::ACCOUNT_TYPE => 'account_type',
        ResponseFields::TEST_REQUEST => 'test_request'
    ];

    /**
     * @param array $handlingSubject
     * @param array $response
     *
     * @return void
     */
    public function handle(array $handlingSubject, array $response)
    {
        /** @var PaymentDataObjectInterface $paymentDataObject */
        $paymentDataObject = $handlingSubject['payment'];
        $payment = $paymentDataObject->getPayment();
        $transactionResponse = $response[ResponseFields::TRANSACTION_RESPONSE];

        foreach ($this->additionalInformation as $responseKey => $paymentKey) {
            if (isset($transactionResponse[$responseKey]) && !empty($transactionResponse[$responseKey])) {
                $payment->setAdditionalInformation($paymentKey, $transactionResponse[$responseKey]);
            }
        }
    }
}
