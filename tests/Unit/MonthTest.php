<?php

namespace Tests\Unit;

use App\Month;
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
    public function converts_to_proper_string() {
        $month = new Month(2017, 6);

        $this->assertEquals('2017-06', (string) $month);

    }

    /** @test */
    public function can_be_created_from_string() {
        $month = Month::fromString('2017-06');

        $this->assertEquals(2017, $month->getYear());
        $this->assertEquals(6, $month->getMonth());

    }

    /** @test */
    public function previous_and_next_return_correct_month() {
        $month = new Month(2017, 6);

        $this->assertEquals('2017-05', $month->previous());
        $this->assertEquals('2017-07', $month->next());
    }


}
