<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Classes\NbpDailyCurrencyRateUrl;

/**
 * Class NbpDailyCurrencyRateUrlTest
 * 
 * @package Tests\Unit
 */
class NbpDailyCurrencyRateUrlTest extends TestCase {

    /**
     * URL generation test
     *
     * @return void
     */
    public function testUrlGenerationTest() {
        $nbpUrl = new NbpDailyCurrencyRateUrl('2020-08-01');
        $desiredUrl = 'http://api.nbp.pl/api/exchangerates/tables/A/2020-08-01';

        $this->assertEquals($desiredUrl, $nbpUrl->url());
    }
}
