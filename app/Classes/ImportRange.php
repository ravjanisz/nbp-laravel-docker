<?php

namespace App\Classes;

use \DateTime;

/**
 * Class ImportRange
 *
 * Class used for prepare monthly import ranges - NBP
 *
 * @package App\Classes
 */
class ImportRange {

    private $initDate;
    private $ranges = [];

    /**
     * ImportRange constructor.
     *
     * Construct with one parameter - initial month date
     *
     * @param DateTime $initDate
     */
    public function __construct(DateTime $initDate) {
        $this->initDate = $initDate;
        $this->initDate->setTime(0, 0, 0, 0);
    }

    /**
     * Function that generate ranges array
     *
     * @return MonthRange []
     *
     * @throws \Exception
     */
    public function ranges() {
        $loopDate = $this->initDate;

        $actualDate = new DateTime();
        $actualDate->setTime(0, 0, 0, 0);
        $actualDate->modify('- 1 month');

        $canIterate = $this->canIterate($loopDate, $actualDate);
        while ($canIterate) {
            $this->ranges[] = new MonthRange($loopDate);
            $loopDate->modify('+ 1 month');
            $canIterate = $this->canIterate($loopDate, $actualDate);
        }

        $actualMonthRange = new MonthRange($loopDate);

        $actualDate->modify('+ 1 month');
        $actualMonthRange->setDateTo($actualDate->format('Y-m-d'));

        $this->ranges[] = $actualMonthRange;

        return $this->ranges;
    }

    /**
     * Function that check if actual date is less or equeal than actual date
     *
     * @param DateTime $loopDate
     * @param DateTime $actualDate
     *
     * @return bool
     */
    protected function canIterate(DateTime $loopDate, DateTime $actualDate) {
        return $loopDate->format('Y-m-01') <= $actualDate->format('Y-m-01');
    }
}