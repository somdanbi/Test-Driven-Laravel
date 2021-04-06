<?php

namespace Tests\Feature;


use App\Billing\FakePaymentGateway;
use App\Billing\PaymentGateway;
use App\Concert;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class PurchaseTicketsTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    function customer_can_purchase_concert_tickets()
    {
        $paymentGateway = new FakePaymentGateway;
        $this->app->instance(PaymentGateway::class, $paymentGateway);

        //Arrange: create a concert
        $concert = factory(Concert::class)->create([ 'ticket_price' => 3250 ]);

        //Act: purchase the ticket
        $this->postJson("/concerts/{$concert->id}/orders", [
            'email'           => 'manut@example.org',
            'ticket_quantity' => 3,
            'payment_token'   => $paymentGateway->getValidTestToken(),
        ])->assertStatus(201);


        //Assert: make sure the customer was charged the correct amount
        $this->assertEquals(9750, $paymentGateway->totalCharges());

        //Make sure that the order exists for this customer
        $order = $concert->orders()->where('email', 'manut@example.org')->first();

        $this->assertNotNull($order);

        $this->assertEquals(3, $order->tickets()->count());
    }


}
