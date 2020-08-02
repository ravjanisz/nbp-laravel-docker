<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Classes\MonthRange;
use \DateTime;

/**
 * Class MonthRangeTest
 * 
 * @package Tests\Unit
 */
class MonthRangeTest extends TestCase {

    /**
     * Date from and date to test
     *
     * @return void
     */
    public function testMonthRangeFirstAndLastTest() {
        $dateTime = new DateTime('2020-08-01');
        $monthRange = new MonthRange($dateTime);

        $this->assertEquals('2020-08-01', $monthRange->getDateFrom());
        $this->assertEquals('2020-08-31', $monthRange->getDateTo());
    }

    /**
     * Date to setting test
     *
     * @return void
     */
    public function testMonthRangeSetMethodTest() {
        $dateTime = new DateTime('2020-08-01');
        $monthRange = new MonthRange($dateTime);

        $monthRange->setDateTo('2020-08-03');

        $this->assertEquals('2020-08-01', $monthRange->getDateFrom());
        $this->assertEquals('2020-08-03', $monthRange->getDateTo());
    }
}
