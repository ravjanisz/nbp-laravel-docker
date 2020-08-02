<?php

namespace App\Classes;

/**
 * Class NbpDailyCurrencyRateUrl
 *
 * Class that generate URL for daily import
 *
 * @package App\Classes
 */
class NbpDailyCurrencyRateUrl implements CurrencyRateUrl {

    const URL = 'http://api.nbp.pl/api/exchangerates/tables/%s/%s';
    const CURRENCY_TABLE = 'A';

    private $date;

    /**
     * NbpDailyCurrencyRateUrl constructor.
     *
     * @param string $date
     */
    public function __construct($date) {
        $this->date = $date;
    }

    /**
     * URL generation
     *
     * @return string
     */
    public function url() {
        return sprintf(NbpDailyCurrencyRateUrl::URL, NbpDailyCurrencyRateUrl::CURRENCY_TABLE, $this->date);
    }
}