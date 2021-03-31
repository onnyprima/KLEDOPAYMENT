<?php

namespace Tests\Feature\Http\Controllers;

use App\Jobs\DeletePayments;
use App\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class PaymentControllerTest extends TestCase
{
    use WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testItStoreNewPayment()
    {
        $response = $this->post(route('payments'), [
            'payment_name' => $this->faker->words(3, true)
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('payments'));
    }

    public function testItStoreNewPaymentBlankPaymentName()
    {
        $this->post(route('payments'), [
            'payment_name' => ''
        ]);
        $errors = session('errors');
        $this->assertEquals($errors->get('payment_name')[0], "The payment name field is required.");
    }

    public function testGetDataPayment()
    {
        $response = $this->get('/payments');

        $response->assertStatus(200);
        $data = $response->original->getData()['data'];

        $response->assertViewHas('data');
    }

    public function testQueueDeletePaymentRunning()
    {
        Queue::fake();
        Queue::assertNothingPushed();

        $this->post(route('paymentsdelete'), []);
        // Assert job dilakukan sekali...
        Queue::assertPushed(DeletePayments::class, 1);
    }

    public function testQueueDeletePaymentSent()
    {
        Queue::fake();
        Queue::assertNothingPushed();

        $this->post(route('paymentsdelete'), []);
        // Assert a memastikan queue terkirim ke channel delete-payment-queue...
        Queue::assertPushedOn('delete-payment-queue', DeletePayments::class);
    }
}
