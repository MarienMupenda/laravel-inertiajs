<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::match(['get','post'],'pay-test', function (Request $request) {


    $data = array (
        "merchant_id" => env('FRESH_PAY_MERCHANT_ID', null),
        "merchant_secrete" => env('FRESH_PAY_MERCHANT_SECRET', null),
        'firstname' => 'SmirlTech',
        'lastname' => 'SmirlTech',
        'method' => 'airtel',
        'action' => 'debit',
        'customer_number' => '0970966587',
        'amount' => '100',
        'currency' => 'CDF',
        'reference' => 'smirltech',
        'e-mail' => 'smirltech@gmail.com',
    );

    $response = Http::post(env('FRESH_PAY_URL'), $data);

    return $response;

})->name('api.payments.test');
