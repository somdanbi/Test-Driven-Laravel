<?php

namespace Tests\Feature;


use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ViewConcertListingTest extends TestCase
{

    use DatabaseTransactions;

    /** @test */
    function user_can_view_a_concert_listing()
    {
        // 1. Arrage
        // create a concert
        $concert = Concert::create([
            'title'                  => 'The Red chord',
            'subtitle'               => 'with Animosity and Lethargy',
            'date'                   => Carbon::parse('December 13, 2021 8:00pm'),
            'ticket_price'           => 3250,
            'venue'                  => 'The Most Pit',
            'venue_address'          => '123 Example Line',
            'city'                   => 'Laraville',
            'state'                  => 'ON',
            'zip'                    => '17916',
            'additional_information' => 'For tickets, call (555) 555-5555.',
        ]);

        // 2. Act
        // View the concert listing
        $this->visit('/concert/' . $concert->id);

        // 3. Assert
        //See the concert details
    }

}
