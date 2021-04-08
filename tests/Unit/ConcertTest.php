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
        $concert = factory(Concert::class)->make([
            'date' => Carbon::parse('2021-12-01'),
        ]);

        $this->assertEquals('December 1, 2021', $concert->formatted_date);
    }

    /** @test */
    function can_get_start_time()
    {
        // Create a concert with a know date
        $concert = factory(Concert::class)->make([
            'date' => Carbon::parse('2021-12-01 17:00:00'),
        ]);

        $this->assertEquals('5:00pm', $concert->formatted_start_time);
    }

    /** @test */
    function can_get_ticket_price_in_dollars()
    {
        $concert = factory(Concert::class)->make([
            'ticket_price' => 6750,
        ]);

        $this->assertEquals('67.50', $concert->ticket_price_in_dollars);
    }


    /** @test */
    function concert_with_a_published_at_date_are_published()
    {
        $publishedConcertA = factory(Concert::class)->create([ 'published_at' => Carbon::parse('-1 week') ]);
        $publishedConcertB = factory(Concert::class)->create([ 'published_at' => Carbon::parse('-1 week') ]);
        $unpublishedConcert = factory(Concert::class)->create([ 'published_at' => null ]);

        $publishedConcerts = Concert::published()->get();

        $this->assertTrue($publishedConcerts->contains($publishedConcertA));
        $this->assertTrue($publishedConcerts->contains($publishedConcertB));
        $this->assertFalse($publishedConcerts->contains($unpublishedConcert));
    }

    /** @test */
    function can_order_concert_tickets()
    {
        //Arrange
        $concert = factory(Concert::class)->create();
        $order = $concert->orderTickets('jane@example.com',3);
        $this->assertEquals('jane@example.com', $order->email);
        $this->assertEquals(3, $order->tickets()->count());

        //Act

        //Assert

    }
}
