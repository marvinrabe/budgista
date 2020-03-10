<?php

namespace Tests\Unit;

use App\Transaction;
use App\Recurring;
use Carbon\Carbon;
use Tests\TestCase;

class RecurringGeneratorTest extends TestCase
{

    /** @test */
    public function it_gets_occurrences()
    {
        $transaction = new Transaction([
            'date' => Carbon::now()->subDay()
        ]);

        $recurrence = new Recurring('FREQ=DAILY;INTERVAL=1');

        $results = $recurrence->getPendingOccurrences($transaction);

        $this->assertCount(2, $results);
        $this->assertEquals(Carbon::now()->format('Y-m-d'), $results[0]->format('Y-m-d'));
        $this->assertEquals(Carbon::now()->addDay()->format('Y-m-d'), $results[1]->format('Y-m-d'));
    }

    /** @test */
    public function it_generates_occurrences()
    {
        $transaction = new Transaction();
        $transaction->id = 123;
        $transaction->date = Carbon::now()->subDay();

        $recurrence = new Recurring('FREQ=DAILY;INTERVAL=1');

        $results = $recurrence->generateOccurrences($transaction);

        $this->assertCount(2, $results);
        $this->assertEquals(Carbon::now()->format('Y-m-d'), $results[0]->date->format('Y-m-d'));
        $this->assertNull($results[0]->id);
        $this->assertFalse($results[0]->recurring);
        $this->assertEquals(Carbon::now()->addDay()->format('Y-m-d'), $results[1]->date->format('Y-m-d'));
        $this->assertNull($results[1]->id);
        $this->assertFalse($results[1]->recurring);
    }

}
