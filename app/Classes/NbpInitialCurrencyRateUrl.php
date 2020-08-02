<?php

namespace App\Classes;

/**
 * Class NbpInitialCurrencyRateUrl
 *
 * Class that generate URL for initial import
 *
 * @package App\Classes
 */
class NbpInitialCurrencyRateUrl implements CurrencyRateUrl {

    const URL = 'http://api.nbp.pl/api/exchangerates/tables/%s/%s/%s';
    const CURRENCY_TABLE = 'A';

    private $monthRange;

    /**
     * NbpInitialCurrencyRateUrl constructor.
     *
     * @param MonthRange $monthRange
     */
    public function __construct(MonthRange $monthRange) {
        $this->monthRange = $monthRange;
    }

    /**
     * URL generation
     *
     * @return string
     */
    public function url() {
        return sprintf(NbpInitialCurrencyRateUrl::URL,
            NbpInitialCurrencyRateUrl::CURRENCY_TABLE,
            $this->monthRange->getDateFrom(),
            $this->monthRange->getDateTo());
    }
}