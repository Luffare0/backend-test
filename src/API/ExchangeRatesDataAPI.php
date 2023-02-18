<?php

namespace Opeepl\BackendTest\API;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

class ExchangeRatesDataAPI extends AbstractExchangeRateAPI
{

    /**
     * @var Client $client
     */
    private $client;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => 'https://api.apilayer.com']);
    }

    /**
     * @throws GuzzleException
     */
    public function getSupportedCurrencies(): array
    {
        $response = $this->makeRequest('/exchangerates_data/symbols');

        $result = \json_decode($response->getBody(), true);

        return \array_keys($result['symbols']);
    }

    /**
     * @throws GuzzleException
     */
    public function getExchangeAmount(int $amount, string $fromCurrency, string $toCurrency): int
    {
        $uri = "/exchangerates_data/convert?to=$toCurrency&from=$fromCurrency&amount=$amount";
        $response = $this->makeRequest($uri);

        $result = \json_decode($response->getBody(), true);

        return $result['result'];
    }

    /**
     * @throws GuzzleException
     */
    public function makeRequest(string $uri): ResponseInterface
    {
        return $this->client->request(
            'GET',
            $uri,
            [RequestOptions::HEADERS => ['apikey' => '2p46MmpLapxo5xkLuEIAfdKkFVFFX6iF']]
        );
    }
}