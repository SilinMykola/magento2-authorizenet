<?php

declare(strict_types=1);

namespace Silin\Authorizenet\Gateway\Converter;

use Magento\Payment\Gateway\Http\ConverterException;
use Magento\Payment\Gateway\Http\ConverterInterface;

class Converter
{
    /**
     * @var ConverterInterface
     */
    private $converter;

    /**
     * @param ConverterInterface $converter
     */
    public function __construct(
        ConverterInterface $converter
    ) {
        $this->converter = $converter;
    }

    /**
     * @param array $request
     * @return array|string
     * @throws ConverterException
     */
    public function convert(array $request)
    {
        return $this->converter->convert($request);
    }
}
