<?php

namespace App\Http\Controllers;

use App\Billing\PaymentGateway;
use App\Concert;

class ConcertOrdersController extends Controller
{

    private $paymentGateway;

    public function __construct(PaymentGateway $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }




    public function storffffe($concertId)
    {

        if ( request()->wantsJson() ) {
            $concert = Concert::find($concertId);

            $ticketQuantity = \request('ticket_quantity');
            $amount = $ticketQuantity * $concert->ticket_price;
            $token = \request('payment_token');

            $this->paymentGateway->charge($amount, $token);

            $order = $concert->orders()->create([ 'email' => request('email') ]);

            foreach (range(1, $ticketQuantity) as $i){
                $order->tickets()->create([]);
            }
          return response([],201);
            //  return response([], 204);
        }

    }

    public function store($concertId)
    {

        \request()->validate([


        ]);


    }
}
