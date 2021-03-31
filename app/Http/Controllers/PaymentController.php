<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Jobs\DeletePayments;
use App\Payment;
use Hoa\File\Link\Read;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App;

class PaymentController extends Controller
{
    public function post(PaymentRequest $paymentRequest)
    {
        $validated = $paymentRequest->validated();
        Payment::create($validated);

        return redirect()->route('payments')
        ->with('success','Post created successfully.');;
    }

    public function get()
    {
        return view('payment', [
            'data' => DB::table('payments')->paginate(15)
        ]);
    }

    public function delete(Request $request)
    {
        $data = [1, 3, 4, 5, 6, 7];//$request->all();
        DeletePayments::dispatch($data)->onQueue('delete-payment-queue');
        return "Event has been sent!";
    }

    public function create()
    {
        return view('addpayment');
    }
}
