<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Classes\MonthRange;
use App\Classes\NbpInitialCurrencyRateUrl;
use \DateTime;

/**
 * Class NbpInitialCurrencyRateUrlTest
 * 
 * @package Tests\Unit
 */
class NbpInitialCurrencyRateUrlTest extends TestCase {

    /**
     * URL generation test
     *
     * @return void
     */
    public function testUrlGenerationTest() {
        $dateTime = new DateTime('2020-08-01');
        $monthRange = new MonthRange($dateTime);
        $nbpUrl = new NbpInitialCurrencyRateUrl($monthRange);
        $desiredUrl = 'http://api.nbp.pl/api/exchangerates/tables/A/2020-08-01/2020-08-31';

        $this->assertEquals($desiredUrl, $nbpUrl->url());
    }
}
