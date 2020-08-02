<?php

namespace App\Classes;

use \DateTime;

/**
 * Class MonthRange
 *
 * Class that gives two date (first and last month day) from date
 *
 * @package App\Classes
 */
class MonthRange {

    private $dateFrom;
    private $dateTo;

    /**
     * MonthRange constructor.
     *
     * @param DateTime $dateTime
     */
    public function __construct(DateTime $dateTime) {
        $this->dateFrom = $dateTime->format('Y-m-01');
        $this->dateTo = $dateTime->format('Y-m-t');
    }

    /**
     * Get first month day date as string
     *
     * @return string
     */
    public function getDateFrom() {
        return $this->dateFrom;
    }

    /**
     * Get last month day date as string
     *
     * @return string
     */
    public function getDateTo() {
        return $this->dateTo;
    }

    /**
     * /**
     * Set last month day date as string
     *
     * @param string $dateTo
     *
     * @return string
     */
    public function setDateTo($dateTo) {
        $this->dateTo = $dateTo;
    }
}