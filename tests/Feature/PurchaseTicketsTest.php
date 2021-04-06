<?php

namespace Tests\Feature;


use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class PurchaseTicketsTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    function customer_can_purchase_concert_tickets()
    {
        //Arrange: create a concert
        $concert = factory(Concert::class)->create([ 'ticket_price' => 3250 ]);

        //Act: purchase the ticket
        $this->json('POST', "/concerts/{$concert->id}/orders", [
            'email'           => 'manut@example.org',
            'ticket_quantity' => 3,
            'payment_token'   => $paymentGateWay->getValidTestToken(),
        ]);

        //Assert: make sure the customer was charged the correct amount
        $this->assertEquals(9750, $paymentGateWay->totalCharges());

        //Make sure that the order exists for this customer
        $order = $concert->orders()->where('email', 'manut@example.org')->first();

        $this->assertNotNull($order);

        $this->assertEquals(3, $order->tickets->count());
    }


}
