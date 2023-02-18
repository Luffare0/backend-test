<?php

namespace Opeepl\BackendTest\API;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

class ExchangeRatesDataAPI extends AbstractExchangeRateAPI
{

    /**
     * @var string
     */
    private $apiKey;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => 'https://api.apilayer.com']);
        //TODO: Load from .env file
        $this->apiKey = '2p46MmpLapxo5xkLuEIAfdKkFVFFX6iF';
    }

    /**
     * @throws GuzzleException
     */
    public function getSupportedCurrencies(): array
    {
        $response = $this->makeRequest('/exchangerates_data/symbols');

        $result = self::getArrayBody($response);

        return \array_keys($result['symbols']);
    }

    /**
     * @throws GuzzleException
     */
    public function getExchangeAmount(int $amount, string $fromCurrency, string $toCurrency): int
    {
        $uri = "/exchangerates_data/convert?to=$toCurrency&from=$fromCurrency&amount=$amount";
        $response = $this->makeRequest($uri);

        $result = self::getArrayBody($response);

        return $result['result'];
    }

    /**
     * @throws GuzzleException
     */
    public function makeRequest(string $uri): ResponseInterface
    {
        //TODO: Check if success=true?
        return $this->client->request(
            'GET',
            $uri,
            [RequestOptions::HEADERS => ['apikey' => $this->apiKey]]
        );
    }

    /**
     * @param ResponseInterface $response
     * @return array
     */
    private static function getArrayBody(ResponseInterface $response): array {
        return \json_decode($response->getBody(), true);
    }
}