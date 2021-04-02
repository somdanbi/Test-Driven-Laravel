<?php

namespace Tests\Feature;


use App\Concert;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use Tests\TestCase;

class ViewConcertListingTest extends TestCase
{

    use  DatabaseMigrations;

    /** @test */
    function user_can_view_a_concert_listing()
    {
        // 1. Arrage
        // create a concert

        $concert = Concert::create([
            'title'                  => 'The Red Chord',
            'subtitle'               => 'with Animosity and Lethargy',
            'date'                   => Carbon::parse('December 13, 2021 8:00pm'),
            'ticket_price'           => 3250,
            'venue'                  => 'The Mosh Pit',
            'venue_address'          => '123 Example Lane',
            'city'                   => 'Laraville',
            'state'                  => 'ON',
            'zip'                    => '17916',
            'additional_information' => 'For tickets, call (555) 555-5555.',
        ]);

        // 2. Act
        // View the concert listing

        $this->get('/concerts/' . $concert->id)
            ->assertStatus(200)
            ->assertSee('The Red Chord')
            ->assertSee('with Animosity and Lethargy')
            ->assertSee('December 13, 2021')
            ->assertSee('8:00pm')
            ->assertSee('32.50')
            ->assertSee('The Mosh Pit')
            ->assertSee('123 Example Lane')
            ->assertSee('Laraville')
            ->assertSee('ON')
            ->assertSee('17916')
            ->assertSee('For tickets, call (555) 555-5555.');


        // 3. Assert
        //See the concert details

    }

    /** @test */
    function user_cannot_view_unpublished_concert_listing()
    {
        $concert = factory(Concert::class)->create([
            'published_at' => null,
        ]);
        $this->get('/concerts/' . $concert->id)
            ->assertStatus(404);
    }

}
