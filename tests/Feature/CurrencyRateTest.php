<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\Models\Currency;

class CurrencyRateTest extends TestCase {

    use DatabaseMigrations;

    /**
     * Actual currency rate test
     *
     * @return void
     */
    public function testActualCurrencyRateTest() {
        $response = $this->get('/api/actual-table');
        $response->assertStatus(200);
        $response->assertJsonPath('status', 'success');
    }

    /**
     * Historical single currency rate empty test
     *
     * @return void
     */
    public function testHistoricalSingleCurrencyRateEmptyTest() {
        $response = $this->get('/api/historical-single/PHP');
        $response->assertStatus(404);
    }

    /**
     * Historical single currency rate test
     *
     * @return void
     */
    public function testHistoricalSingleCurrencyRateTest() {
        $currency = new Currency();
        $currency->code = 'PHP';
        $currency->name = 'PHP currency';
        $currency->save();

        $response = $this->get('/api/historical-single/PHP');
        $response->assertStatus(200);
        $response->assertJsonPath('status', 'success');
    }
}
