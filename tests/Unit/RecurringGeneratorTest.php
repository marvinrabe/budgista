<?php

namespace Tests\Unit;

use App\Models\Transaction;
use App\RecurringGenerator;
use App\RRule;
use Carbon\Carbon;

class RecurringGeneratorTest extends \Tests\TestCase
{

    /** @test */
    public function it_returns_empty_array_when_not_recurring()
    {
        $transaction = new Transaction();
        $transaction->date = Carbon::now();
        $transaction->rrule = null;

        $generator = new RecurringGenerator();
        $results = $generator->getPendingOccurrences($transaction);

        $this->assertCount(0, $results);
    }

    /** @test */
    public function it_gets_occurrences()
    {
        $transaction = new Transaction();
        $transaction->date = Carbon::now()->subDay();
        $transaction->rrule = new RRule('FREQ=DAILY;INTERVAL=1');

        $generator = new RecurringGenerator();
        $results = $generator->getPendingOccurrences($transaction);

        $this->assertCount(2, $results);
        $this->assertEquals(Carbon::now()->format('Y-m-d'), $results[0]->format('Y-m-d'));
        $this->assertEquals(Carbon::now()->addDay()->format('Y-m-d'), $results[1]->format('Y-m-d'));
    }

    /** @test */
    public function it_returns_current_transaction()
    {
        $transaction = new Transaction();
        $transaction->date = Carbon::now();
        $transaction->rrule = null;

        $generator = new RecurringGenerator();
        $results = $generator->generateOccurrences($transaction);

        $this->assertCount(1, $results);
        $this->assertEquals($transaction, $results[0]);
    }

    /** @test */
    public function it_generates_occurrences()
    {
        $transaction = new Transaction();
        $transaction->id = 123;
        $transaction->date = Carbon::now()->subDay();
        $transaction->rrule = new RRule('FREQ=DAILY;INTERVAL=1');

        $generator = new RecurringGenerator();
        $results = $generator->generateOccurrences($transaction);

        $this->assertCount(3, $results);
        $this->assertEquals(Carbon::now()->subDay()->format('Y-m-d'), $results[0]->date->format('Y-m-d'));
        $this->assertEquals(123, $results[0]->id);
        $this->assertFalse($results[0]->recurring);
        $this->assertEquals(Carbon::now()->format('Y-m-d'), $results[1]->date->format('Y-m-d'));
        $this->assertNull($results[1]->id);
        $this->assertFalse($results[1]->recurring);
        $this->assertEquals(Carbon::now()->addDay()->format('Y-m-d'), $results[2]->date->format('Y-m-d'));
        $this->assertNull($results[2]->id);
        $this->assertTrue($results[2]->recurring);
    }

}
