<?php

namespace Tests\Unit;

use App\Month;
use Carbon\Carbon;
use Tests\TestCase;

class MonthTest extends TestCase
{

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
     * @test
     * @dataProvider invalidData
     */
    public function test_invalid_constructor($year, $month)
    {
        $this->expectException(\InvalidArgumentException::class);

        new Month($year, $month);
    }


    public function validData()
    {
        return [
            [1900, 1],
            [2099, 12],
            [2017, 6]
        ];
    }

    /**
     * @test
     * @dataProvider validData
     */
    public function test_valid_constructor($year, $month)
    {
        $monthObject = new Month($year, $month);

        $this->assertInstanceOf(Month::class, $monthObject);
        $this->assertEquals($year, $monthObject->getYear());
        $this->assertEquals($month, $monthObject->getMonth());
    }

    /** @test */
    public function converts_to_proper_string()
    {
        $month = new Month(2017, 6);

        $this->assertEquals('2017-06', (string)$month);

    }

    /** @test */
    public function can_be_created_from_string()
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
     * @test
     * @dataProvider nextAndPreviousData
     */
    public function previous_and_next_return_correct_month($year, $month, $prev, $next)
    {
        $monthObject = new Month($year, $month);

        $this->assertEquals($prev, (string) $monthObject->previous());
        $this->assertEquals($next, (string) $monthObject->next());

        // Check if month object doesnt mutate
        $this->assertEquals($year, $monthObject->getYear());
        $this->assertEquals($month, $monthObject->getMonth());
    }


    /** @test */
    public function create_month_that_equals_current_month()
    {
        $knownDate = Carbon::create(2001, 5, 21);
        Carbon::setTestNow($knownDate);

        $month = Month::current();

        $this->assertEquals(2001, $month->getYear());
        $this->assertEquals(5, $month->getMonth());
    }


    /** @test */
    public function test_first_and_last_day()
    {
        $month = new Month(2017, 10);

        $this->assertEquals('20170930', $month->previous()->lastDay()->format('Ymd'));
        $this->assertEquals('20170901', $month->previous()->firstDay()->format('Ymd'));

        $this->assertEquals('20171031', $month->lastDay()->format('Ymd'));
        $this->assertEquals('20171001', $month->firstDay()->format('Ymd'));

        $this->assertEquals('20171130', $month->next()->lastDay()->format('Ymd'));
        $this->assertEquals('20171101', $month->next()->firstDay()->format('Ymd'));
    }

}
