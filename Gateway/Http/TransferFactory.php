<?php

declare(strict_types=1);

namespace Silin\Authorizenet\Gateway\Http;

use Magento\Payment\Gateway\Http\ConverterException;
use Magento\Payment\Gateway\Http\Transfer;
use Magento\Payment\Gateway\Http\TransferBuilder;
use Magento\Payment\Gateway\Http\TransferFactoryInterface;
use Magento\Payment\Gateway\Http\TransferInterface;
use Silin\Authorizenet\Gateway\Converter\Converter;

class TransferFactory implements TransferFactoryInterface
{
    /**
     * @var TransferBuilder
     */
    private $transferBuilder;

    /**
     * @var Converter
     */
    private $converter;

    /**
     * @param TransferBuilder $transferBuilder
     * @param Converter $converter
     */
    public function __construct(
        TransferBuilder $transferBuilder,
        Converter $converter
    ) {
        $this->transferBuilder = $transferBuilder;
        $this->converter = $converter;
    }

    /**
     * @param array $request
     * @return Transfer|TransferInterface
     * @throws ConverterException
     */
    public function create(array $request)
    {
        return $this->transferBuilder
            ->setUri('https://apitest.authorize.net/xml/v1/request.api')
            ->setMethod('POST')
            ->setBody($this->converter->convert($request))
            ->setHeaders(['Content-Type' => 'application/json'])
            ->build();
    }
}
