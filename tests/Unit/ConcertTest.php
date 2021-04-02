<?php

namespace Tests\Unit;


use App\Concert;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ConcertTest extends TestCase
{

    use DatabaseMigrations, DatabaseTransactions;

    /** @test */
    function can_get_formatted_date()
    {
        // Create a concert with a know date
        $concert = factory(Concert::class)->create([
            'date' => Carbon::parse('2021-12-01'),
        ]);


        $this->assertEquals('December 1, 2021', $concert->formatted_date);
    }

}
