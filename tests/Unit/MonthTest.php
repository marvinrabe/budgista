<?php

namespace Tests\Unit;

use App\Month;
use Carbon\Carbon;
use Tests\TestCase;

class MonthTest extends TestCase
{
    public function validData()
    {
        return [
            [1900, 1],
            [2099, 12],
            [2017, 6]
        ];
    }

    /**
     * @dataProvider validData
     */
    public function testConstructor($year, $month)
    {
        $monthObject = new Month($year, $month);

        $this->assertInstanceOf(Month::class, $monthObject);
        $this->assertEquals($year, $monthObject->getYear());
        $this->assertEquals($month, $monthObject->getMonth());
    }

    public function invalidData()
    {
        return [
            [1899, 1],
            [2100, 1],
            [2010, 0],
            [2010, 13],
        ];
    }

    /**
     * @dataProvider invalidData
     */
    public function testValidation($year, $month)
    {
        $this->expectException(\InvalidArgumentException::class);

        new Month($year, $month);
    }

    public function testToString()
    {
        $month = new Month(2017, 6);

        $this->assertEquals('2017-06', (string) $month);

    }

    public function testFromString()
    {
        $month = Month::fromString('2017-06');

        $this->assertEquals(2017, $month->getYear());
        $this->assertEquals(6, $month->getMonth());

    }

    public function nextAndPreviousData()
    {
        return [
            [2017, 1, '2016-12', '2017-02'],
            [2017, 6, '2017-05', '2017-07'],
            [2017, 12, '2017-11', '2018-01']
        ];
    }

    /**
     * @dataProvider nextAndPreviousData
     */
    public function testPreviousMonthAndNextMonth($year, $month, $prev, $next)
    {
        $monthObject = new Month($year, $month);

        $this->assertEquals($prev, (string) $monthObject->previous());
        $this->assertEquals($next, (string) $monthObject->next());

        // Check if month object doesnt mutate
        $this->assertEquals($year, $monthObject->getYear());
        $this->assertEquals($month, $monthObject->getMonth());
    }

    public function testCurrentMonth()
    {
        $knownDate = Carbon::create(2001, 5, 21);
        Carbon::setTestNow($knownDate);

        $month = Month::current();

        $this->assertEquals(2001, $month->getYear());
        $this->assertEquals(5, $month->getMonth());
    }

    public function testFirstAndLastDay()
    {
        $month = new Month(2017, 10);

        $this->assertEquals('20170930', $month->previous()->lastDay()->format('Ymd'));
        $this->assertEquals('20170901', $month->previous()->firstDay()->format('Ymd'));

        $this->assertEquals('20171031', $month->lastDay()->format('Ymd'));
        $this->assertEquals('20171001', $month->firstDay()->format('Ymd'));

        $this->assertEquals('20171130', $month->next()->lastDay()->format('Ymd'));
        $this->assertEquals('20171101', $month->next()->firstDay()->format('Ymd'));
    }

    public function testRange()
    {
        $expected = ['2017-12'];
        for ($month = 1; $month <= 11; $month++) {
            $expected[] = '2018-'.str_pad($month, 2, '0', STR_PAD_LEFT);
        };

        $result = Month::range(Month::fromString('2017-12'), Month::fromString('2018-11'))
            ->map(function (Month $month) {
                return (string) $month;
            })
            ->toArray();

        $this->assertTrue(array_diff($expected, $result) == []);

    }

    public function testSingleRange()
    {
        $expected = ['2017-12'];

        $result = Month::range(Month::fromString('2017-12'), Month::fromString('2017-12'))
            ->map(function (Month $month) {
                return (string) $month;
            })
            ->toArray();

        $this->assertTrue(array_diff($expected, $result) == []);

    }

}
