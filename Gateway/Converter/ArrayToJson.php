<?php

declare(strict_types=1);

namespace Silin\Authorizenet\Gateway\Converter;

use Magento\Framework\Serialize\SerializerInterface;
use Magento\Payment\Gateway\Http\ConverterInterface;

class ArrayToJson implements ConverterInterface
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * @param SerializerInterface $serializer
     */
    public function __construct(
        SerializerInterface $serializer
    ) {
        $this->serializer = $serializer;
    }

    /**
     * @inheridoc
     */
    public function convert($response)
    {
        return $this->serializer->serialize($response);
    }
}
