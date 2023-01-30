<?php

declare(strict_types=1);

namespace Silin\Authorizenet\Gateway\Http;

use Magento\Framework\Http\ZendClient;
use Magento\Framework\Http\ZendClientFactory;
use Magento\Payment\Gateway\Http\ClientException;
use Magento\Payment\Gateway\Http\ClientInterface;
use Magento\Payment\Gateway\Http\ConverterException;
use Magento\Payment\Gateway\Http\ConverterInterface;
use Magento\Payment\Gateway\Http\TransferInterface;
use Magento\Payment\Model\Method\Logger;

class Client implements ClientInterface
{

    /**
     * @var ZendClientFactory;
     */
    private ZendClientFactory $clientFactory;
    /**
     * @var ConverterInterface
     */
    private ConverterInterface $converter;

    /**
     * @var Logger
     */
    private Logger $logger;

    /**
     * @param ZendClientFactory $clientFactory
     * @param Logger $logger
     * @param ConverterInterface $converter
     */
    public function __construct(
        ZendClientFactory $clientFactory,
        Logger $logger,
        ConverterInterface $converter
    ) {
        $this->clientFactory = $clientFactory;
        $this->logger = $logger;
        $this->converter = $converter;
    }

    /**
     * @param TransferInterface $transferObject
     * @return array
     * @throws ClientException
     * @throws ConverterException
     */
    public function placeRequest(TransferInterface $transferObject): array
    {
        $log = [
            'request_uri' => $transferObject->getUri(),
            'request' => $this->converter
                ? $this->converter->convert($transferObject->getBody())
                : $transferObject->getBody()
        ];

        /** @var  ZendClient $client */
        $client = $this->clientFactory->create();
        $result = [];
        try {
            $client->setConfig($transferObject->getClientConfig());
            $client->setMethod($transferObject->getMethod());
            $client->setRawData($transferObject->getBody(), 'application/json');
            $client->setHeaders($transferObject->getHeaders());
            $client->setUrlEncodeBody($transferObject->shouldEncode());
            $client->setUri($transferObject->getUri());

            $response = $client->request();

            $result = $this->converter
                ? $this->converter->convert($response->getBody())
                : [$response->getBody()];

            $log['response'] = $result;
        } catch (\Zend_Http_Client_Exception $exception) {
            throw new ClientException(__($exception->getMessage()));
        } catch (ConverterException $exception) {
            throw $exception;
        } finally {
            $this->logger->debug($log);
        }

        return $result;
    }
}
