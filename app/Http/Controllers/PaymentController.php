<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Helpers\Helpers;
use Illuminate\Http\Response;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\PaymentRequest;
use DB;
use App\Jobs\SendEmailJob;
use App\Jobs\ApplyPaymentJob;
use App\Jobs\ReceivedPaymentJob;
use GuzzleHttp\Client;
use Inertia\Inertia;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if (Helpers::checkKey($request->ApiKey)) {
            return "Success";
        }

        abort(404);


        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(PaymentRequest $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(PaymentRequest $request)
    {
        $action = ['debit', 'credit', 'verify'];
        $state = ['pending', 'processing', 'done', 'failed'];

        $payment = new Payment();
        $payment->method = $request->method;
        $payment->action = $action[0];
        $payment->customer_number = $request->customer_number;
        $payment->amount = $request->amount;
        $payment->currency = $request->currency;
        $payment->reference = Helpers::randString();
        $payment->company_id = $request->company_id ?? 0;
        $payment->reference_name = $request->reference_name;
        $payment->reference_id = $request->reference_id;
        $payment->user_id = $request->user_id;
        $payment->email = $request->email;
        $payment->save();

        $data = [
            "merchant_id" => env('FRESH_PAY_MERCHANT_ID', null),
            "merchant_secrete" => env('FRESH_PAY_MERCHANT_SECRET', null),
            "amount" => $payment->amount,
            "currency" => strtoupper($payment->currency),
            "action" => $payment->action,
            "customer_number" => $payment->customer_number,
            "firstname" => env('FRESH_PAY_FIRSTNAME', null),
            "lastname" => env('FRESH_PAY_LASTNAME', null),
            "email" => env('FRESH_PAY_EMAIL', null),
            "reference" => $payment->reference,
            "method" => $payment->method,
            "callback_url" => env('CALL_BACK_URL', null) . "/$payment->id",
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->post(env('FRESH_PAY_API_URL', null), $data);
        $responseData = json_decode($response, true);
        $comment = $responseData['Comment'];
        $status = $response->status();
        if ($response->ok()) {
            return Helpers::processingPayment($payment->id, $state[1], $comment, $responseData['Transaction_id']);
        } else {
            return Helpers::errorPayment($response->status());
        }
    }


    public function test(Request $request)
    {

        $request->validate([
            'number' => 'required|numeric|digits:10',
        ]);

        $number = $request->number;
        $method = Helpers::getPaymentMethod($number);


        $data = array(
            "merchant_id" => env('FRESH_PAY_MERCHANT_ID', null),
            "merchant_secrete" => env('FRESH_PAY_MERCHANT_SECRET', null),
            'firstname' => 'SmirlTech',
            'lastname' => 'SmirlTech',
            'method' => $method,
            'action' => 'debit',
            'customer_number' => '0970966587',
            'amount' => '100',
            'currency' => 'CDF',
            'reference' => 'smirltech',
            'e-mail' => 'smirltech@gmail.com',
        );

        $response = Http::acceptJson()
            ->post(env('FRESH_PAY_URL'), $data);

        return redirect(\route('items.checkout',$response->json()));
    }

    /**
     * Display the specified resource.
     *
     * @param Payment $payment
     * @return Payment
     */
    public function show(Request $request, Payment $payment): Payment
    {

        return $payment;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Payment $payment
     * @return Response
     */
    public function edit(Payment $payment)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Payment $payment
     * @return Response
     */
    public function update(Request $request, Payment $payment)
    {

        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Payment $payment
     * @return Response
     */
    public function destroy()
    {
        abort(405);
    }

    public function forbiden()
    {
        return response()->view("forbiden", ['message' => "Forbiden"], 403);
    }


    public function callBack($id)
    {
        $payment = Payment::where('id', $id)->first();
        if (!$payment == null) {
            switch ($payment->state) {

                case "failed":
                    return $this->errorResponse($payment, $payment->comment, 200);
                    break;
                case "done":
                    $data = [
                        'paymentId' => $payment->id,
                        'comment' => $payment->comment,
                        "state" => 'done',
                        'status' => 'Successful',
                        'transaction_id' => $payment->transaction_id,
                        'financial_institution_id' => $payment->financial_institution_id,
                        "amount" => $payment->amount,
                        "currency" => $payment->currency,
                        "action" => $payment->action,
                        "customer_number" => $payment->customer_number,
                        "reference" => $payment->reference,
                        "method" => $payment->method,
                    ];
                    return response()->json($data, 200);
                    break;
                default:
                    $data = [
                        "merchant_id" => env('FRESH_PAY_MERCHANT_ID', null),
                        "merchant_secrete" => env('FRESH_PAY_MERCHANT_SECRET', null),
                        "action" => 'verify',
                        "reference" => $payment->reference,
                    ];
                    $response = Http::withHeaders([
                        'Content-Type' => 'application/json'
                    ])->post(env('FRESH_PAY_API_URL', null), $data);

                    $responseData = json_decode($response, true);
                    $Financial_Institution_id = $responseData['Financial_Institution_id'];
                    $Trans_Status = $responseData['Trans_Status'];
                    $status = $response->status();
                    if ($response->ok()) {
                        if ($Trans_Status == "Successful") {
                            $setPayment = Payment::where('id', $payment->id)->update([
                                'state' => 'done',
                                'comment' => 'Transaction Received Successfully',
                                'financial_institution_id' => $Financial_Institution_id,
                                'payment_date' => now(),]);

                            dispatch(new ReceivedPaymentJob($payment->id));

                            $data = [
                                'paymentId' => $payment->id,
                                'comment' => $payment->comment,
                                "state" => 'done',
                                'status' => 'Successful',
                                'transaction_id' => $payment->transaction_id,
                                'financial_institution_id' => $Financial_Institution_id,
                                "amount" => $payment->amount,
                                "currency" => $payment->currency,
                                "action" => $payment->action,
                                "customer_number" => $payment->customer_number,
                                "reference" => $payment->reference,
                                "method" => $payment->method,
                            ];
                            return response()->json($data, 200);
                        }
                        $data = [
                            'paymentId' => $payment->id,
                            'comment' => $payment->comment,
                            "state" => $payment->state,
                            'status' => 'Submitted',
                            'transaction_id' => $payment->transaction_id,
                            'financial_institution_id' => $payment->financial_institution_id, "amount" => $payment->amount,
                            "currency" => $payment->currency,
                            "action" => $payment->action,
                            "customer_number" => $payment->customer_number,
                            "reference" => $payment->reference,
                            "method" => $payment->method,
                        ];
                        return response()->json($data, 200);
                    }


            }
        }
        abort(404);
    }


}
