<?php
namespace Opeepl\BackendTest\Service;

use GuzzleHttp\Exception\ClientException;
use Opeepl\BackendTest\API\ExchangeRatesDataAPI;
use PHPUnit\Framework\TestCase;

class ExchangeRateServiceTest extends TestCase {

    protected $exchangeRateService;

    public function setUp(): void {
        $this->exchangeRateService = new ExchangeRateService(new ExchangeRatesDataAPI());
    }

    /**
     * @test
     */
    public function getSupportedCurrenciesTest() {
        $currencies = $this->exchangeRateService->getSupportedCurrencies();

        $this->assertContains('USD', $currencies, 'Expected USD to be a supported currency');
        $this->assertContains('EUR', $currencies, 'Expected EUR to be a supported currency');
        $this->assertContains('DKK', $currencies, 'Expected DKK to be a supported currency');
        $this->assertContains('CAD', $currencies, 'Expected CAD to be a supported currency');
    }

    public function notSupportedCurrenciesTest() {
        $currencies = $this->exchangeRateService->getSupportedCurrencies();
        $this->assertNotContains('a made up currency', $currencies, 'Did not expect a made up currency to be supported');
        $this->assertNotContains('BTC', $currencies, 'Did not expect BTC to be supported');
    }

    /**
     * @test
     */
    public function getExchangeAmountEURToDKKTest() {
        $amount = $this->exchangeRateService->getExchangeAmount(100, 'EUR', 'DKK');

        // Because of the fixed-rate policy between DKK and EUR, we should be able to expect 1 EUR to be between 7.4 and 7.6.
        $this->assertTrue(740 < $amount && $amount < 760);
    }

    /**
     * @test
     */
    public function getExchangeAmountUSDToCADTest() {
        $amount = $this->exchangeRateService->getExchangeAmount(200, 'USD', 'CAD');

        // For the sake of simplicity, we expect USD to CAD to be between 1.2 and 1.45.
        $this->assertTrue(240 < $amount && $amount < 290);
    }

    /**
     * @test
     */
    public function getExchangeAmountUSDToUSDTest() {
        $amount = $this->exchangeRateService->getExchangeAmount(200, 'USD', 'USD');

        $this->assertEquals(200, $amount);
    }

    /**
     * @test
     */
    public function getExchangeAmountNotSupportedTest() {

        $this->expectException(ClientException::class);
        $this->exchangeRateService->getExchangeAmount(200, 'a made up currency', 'USD');
    }
}
