<?php

namespace Opeepl\BackendTest\API;

use Psr\Http\Message\ResponseInterface;

abstract class AbstractExchangeRateAPI
{

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