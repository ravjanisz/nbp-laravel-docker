<?php

namespace App\Console\Commands;

use App\Classes\NbpDailyCurrencyRateUrl;
use App\Exceptions\RequestException;
use App\Models\Currency;
use App\Models\Rate;
use Illuminate\Console\Command;
use \DateTime;
use \Requests;

/**
 * Class DailyCurrencyRatesImport
 *
 * Command for daily currency rates import
 *
 * @package App\Console\Commands
 */
class DailyCurrencyRatesImport extends Command {

    protected $signature = 'rav:daily-currency-rates-import';

    protected $description = 'Import today currency rates';

    /**
     * DailyCurrencyRatesImport constructor.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Import currency rates from actual date
     *
     * @throws \Exception
     */
    public function handle() {
        $this->info('Start');

        $initDate = new DateTime('2020-07-31');
        $todayUrl = new NbpDailyCurrencyRateUrl($initDate->format('Y-m-d'));

        $url = $todayUrl->url();

        $this->warn('Fetching currency rates from:' . $url);

        try {
            $currencyRates = $this->request($url);
        } catch (RequestException $e) {
            $this->error('Error occurs: ' . $e->getMessage());
            die;
        }

        $this->warn('Importing currency rates ...');
        foreach ($currencyRates as $key => $currencyRate) {
            $number = $currencyRate['no'];
            $date = new DateTime($currencyRate['effectiveDate']);

            foreach ($currencyRate['rates'] as $rate) {
                $currency = $this->currency($rate['code'], $rate['currency']);
                $this->rate($currency->id, $number, $date->format('Y-m-d'), $rate['mid']);
                $this->info('Currency rate for ' . $currency->code . ' - ' . $currency->name . ' was imported');
            }

            $this->warn('Currency rates (' . count($currencyRate['rates']) . ') was imported for: ' . $date->format('Y-m-d'));
        }

        $this->info('Done');
    }

    /**
     * Request NBP API for data
     *
     * @param string $url
     *
     * @return []
     *
     * @throws RequestException
     */
    protected function request($url) {
        $headers = ['Accept' => 'application/json'];
        $request = Requests::get($url, $headers);

        if ($request->status_code == 200) {
            return json_decode($request->body, true);
        }

        if ($request->status_code == 404) {
            return [];
        }

        throw new RequestException("Invalid rate API response.");
    }

    /**
     * Get/save currency
     *
     * @param string $code
     * @param string $name
     *
     * @return Currency
     */
    protected function currency($code, $name) {
        $currency = Currency::where('code', $code)->first();
        if (!is_null($currency)) {
            return $currency;
        }

        $currency = new Currency();
        $currency->code = $code;
        $currency->name = $name;

        $currency->save();

        return $currency;
    }

    /**
     * Get/save currency rate
     *
     * @param integer $currencyId
     * @param string $number
     * @param string $date
     * @param string $price
     *
     * @return Rate
     */
    protected function rate($currencyId, $number, $date, $price) {
        $rate = Rate::where(['currency_id' => $currencyId, 'date' => $date])->first();
        if (!is_null($rate)) {
            return $rate;
        }

        $rate = new Rate();
        $rate->currency_id = $currencyId;
        $rate->number = $number;
        $rate->date = $date;
        $rate->price = $price;

        $rate->save();

        return $rate;
    }
}
