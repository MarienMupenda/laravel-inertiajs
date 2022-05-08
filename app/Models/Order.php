<?php

namespace App\Models;

use App\Helpers\Helpers;
use Clockwork\Request\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class Order extends Model
{
    use HasFactory;

    protected $with = ['items'];

    public function items() {
        return $this->hasManyThrough(Item::class,OrderItem::class,'order_id','id','id','item_id');
    }



    // pay
    public function pay(Request $request){

        $payment = new Payment();

            $payment->method = $request->method;
            $payment->action = "debit";
            $payment->customer_number = $request->customer_number;
            $payment->amount = $request->amount;
            $payment->currency = $request->currency;
            $payment->reference = Helpers::randString();
            $payment->company_id = $request->company_id ?? 0;
            $payment->reference_name = $request->reference_name;
            $payment->user_id = Auth::user()->id;
            $payment->email = Auth::user()->email;
            $payment->save();

            if ($payment) {

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

               return $data;
            }

    }


    public function orderItems() {
        return $this->hasMany(OrderItem::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function shippingAddress() {
        return $this->belongsTo(ShippingAddress::class);
    }

    public function payment() {
        return $this->belongsTo(Payment::class);
    }

    public function coupon() {
        return $this->belongsTo(Coupon::class);
    }


    public function getTotalAttribute() {
        return $this->items->sum('price') * $this->quantity;
    }

    // get quantity of all items in order
    public function getQuantityAttribute() {
        return $this->orderItems->sum('quantity');
    }

    //get currency of all items in order
    public function getCurrencyAttribute() {
        return $this->items->first()->currency;
    }

    // get item first in order
    public function getItemAttribute() {
        return $this->items->first();
    }
}
