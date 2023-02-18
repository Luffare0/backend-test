<?php
namespace Opeepl\BackendTest\Service;

use Opeepl\BackendTest\API\AbstractExchangeRateAPI;

/**
 * Main entrypoint for this library.
 */
class ExchangeRateService {

    /**
     * @var AbstractExchangeRateAPI
     */
    private $abstractExchangeRateAPI;

    public function __construct(AbstractExchangeRateAPI $abstractExchangeRateAPI)
    {
        $this->abstractExchangeRateAPI = $abstractExchangeRateAPI;
    }


    /**
     * Return all supported currencies
     *
     * @return array<string>
     */
    public function getSupportedCurrencies(): array {
        return $this->abstractExchangeRateAPI->getSupportedCurrencies();
    }

    /**
     * Given the $amount in $fromCurrency, it returns the corresponding amount in $toCurrency.
     *
     * @param int $amount
     * @param string $fromCurrency
     * @param string $toCurrency
     * @return int
     */
    public function getExchangeAmount(int $amount, string $fromCurrency, string $toCurrency): int {
        return $this->abstractExchangeRateAPI->getExchangeAmount($amount, $fromCurrency, $toCurrency);
    }
}
