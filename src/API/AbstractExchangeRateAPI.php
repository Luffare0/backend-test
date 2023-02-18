<?php

namespace Opeepl\BackendTest\API;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractExchangeRateAPI
{

    /**
     * @var Client $client
     */
    protected $client;

    /**
     * @return array<string>
     */
    public abstract function getSupportedCurrencies(): array;

    /**
     * @param int $amount
     * @param string $fromCurrency
     * @param string $toCurrency
     * @return int
     */
    public abstract function getExchangeAmount(int $amount, string $fromCurrency, string $toCurrency): int;

    /**
     * @param string $uri
     * @return ResponseInterface
     */
    public abstract function makeRequest(string $uri) : ResponseInterface;
}