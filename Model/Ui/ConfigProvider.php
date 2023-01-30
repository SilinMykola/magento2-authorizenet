<?php

declare(strict_types=1);

namespace Silin\Authorizenet\Model\Ui;

use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Payment\Gateway\ConfigInterface;

class ConfigProvider implements ConfigProviderInterface
{
    public const CODE = 'silin_authorizenet';

    /**
     * @var ConfigInterface
     */
    private $config;

    /**
     * * @param ConfigInterface $config
     */
    public function __construct(
        ConfigInterface $config
    ) {
        $this->config = $config;
    }

    public function getConfig(): array
    {
        if (!$this->config->getValue('active')) {
            return [];
        }

        return [
            'payment' => [
                self::CODE => [
                    'isActive' => $this->config->getValue('active'),
                    'title' => 'Authorize.Net Payment'
                ]
            ]
        ];
    }
}
