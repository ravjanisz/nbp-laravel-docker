<?php

namespace App\Classes;

/**
 * Interface CurrencyRateUrl
 *
 * Every API should return url that can be used for fetching data
 *
 * @package App\Classes
 */
interface CurrencyRateUrl {

    public function url();
}