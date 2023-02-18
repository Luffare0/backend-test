<?php
namespace Opeepl\BackendTest\Service;

use Opeepl\BackendTest\API\AbstractExchangeRateAPI;

/**
 * Main entrypoint for this library.
 */
class ExchangeRateService {

    /**
     * @var AbstractExchangeRateAPI[]
     */
    private $abstractExchangeRateAPIs;

    public function __construct(array $abstractExchangeRateAPIs)
    {
        $this->abstractExchangeRateAPIs = $abstractExchangeRateAPIs;
    }


    /**
     * Return all supported currencies
     *
     * @return array<string>
     */
    public function getSupportedCurrencies(): array {
        $supportedCurrencies = [];
        foreach($this->abstractExchangeRateAPIs as $abstractExchangeRateAPI) {
            $supportedCurrencies = \array_merge($supportedCurrencies, $abstractExchangeRateAPI->getSupportedCurrencies());
        }

        return \array_unique($supportedCurrencies);
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
        foreach($this->abstractExchangeRateAPIs as $abstractExchangeRateAPI) {
            if($abstractExchangeRateAPI->canConvert($fromCurrency, $toCurrency)) {
                return $abstractExchangeRateAPI->getExchangeAmount($amount, $fromCurrency, $toCurrency);
            }
        }

        return -1;
    }
}
