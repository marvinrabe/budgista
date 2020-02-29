<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StatisticsTest extends TestCase
{
    use RefreshDatabase;


    public function testIndex()
    {
        $this
            ->signIn()
            ->get('/statistics')
            ->assertInertiaViewIs('Statistics/Index');
    }

}
