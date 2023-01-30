<?php

declare(strict_types=1);

namespace Silin\Authorizenet\Gateway\Request;

use Magento\Payment\Gateway\Request\BuilderInterface;
class RequestBuilder implements BuilderInterface
{
    /**
     * @var BuilderInterface
     */
    private BuilderInterface $builderComposite;

    /**
     * @param BuilderInterface $builder
     */
    public function __construct(
        BuilderInterface $builder
    ) {
        $this->builderComposite = $builder;
    }

    /**
     * @param array $buildSubject
     *
     * @return array
     */
    public function build(array $buildSubject): array
    {
        return [
            'createTransactionRequest' => [
                'merchantAuthentication' => [
                    'name' => '5S9xYj5H', //API login ID
                    'transactionKey' => '7Q2V9E6Pk32xPWaH' //API transaction key
                ],
                'transactionRequest' => $this->builderComposite->build($buildSubject)
            ]
        ];
    }
}
