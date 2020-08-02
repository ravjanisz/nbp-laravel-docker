<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Classes\ImportRange;
use App\Classes\MonthRange;
use \DateTime;

/**
 * Class ImportRangeTest
 * 
 * @package Tests\Unit
 */
class ImportRangeTest extends TestCase {

    /**
     * Ranges for actual date tests
     *
     * @return void
     */
    public function testImportRangeActualTest() {
        $initDate = '2020-07-01';
        $endDate = date('Y-m-d');

        $initTimestamp = strtotime($initDate);
        $endTimestamp = strtotime($endDate);
        $initYear = date('Y', $initTimestamp);
        $endYear = date('Y', $endTimestamp);
        $initMonth = date('m', $initTimestamp);
        $endMonth = date('m', $endTimestamp);
        $monthQuantity = (($endYear - $initYear) * 12) + ($endMonth - $initMonth) + 1;

        $initTime = new DateTime($initDate);
        $importRange = new ImportRange($initTime);
        $ranges = $importRange->ranges();

        $this->assertEquals($monthQuantity, count($ranges));
        foreach ($ranges as $range) {
            $this->assertInstanceOf(MonthRange::class, $range);
        }
        $this->assertEquals($initDate, $ranges[0]->getDateFrom());
        $this->assertEquals(date('Y-m-t', strtotime($initDate)), $ranges[0]->getDateTo());

        $this->assertEquals($endDate, end($ranges)->getDateTo());
    }
}
