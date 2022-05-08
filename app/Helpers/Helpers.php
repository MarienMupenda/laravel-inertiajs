<?php

namespace App\Helpers;

use App\Jobs\SendEmailJob;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\SendMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Exception\NotReadableException;
use phpseclib3\Math\PrimeField\Integer;
use Intervention\Image\Facades\Image;


class Helpers
{

    public static function error()
    {
        return abort(404);
    }

    /*
    public static function uploadItemImageApi(Request $request)
    {
        if ($request->has('image') and $request->has('ext')) {

            $image = $request->input('image');
            $extension = $request->input('ext');

            $image = base64_decode($image);

            $fileNameToStore = time() . '.' . $extension;

            //Create thumbanil
            $thumbnail=Image::make($image->getRealPath());
            $thumbnail->resize(150, 150, function ($constraint) {
                $constraint->aspectRatio();
            });
            $thumbnail->stream();
            Storage::put('public/companies/' .  $request->input('company_id') . '/items/'.'thumbnail/' . $fileNameToStore, $thumbnail);

            Storage::put('public/companies/' . $request->input('company_id') . '/items/' . $fileNameToStore, $image);

            return $fileNameToStore;
        } else {
            return "";
        }
    }
    */

    public static function uploadItemImage(Request $request, $company)
    {

        $image = $request->file('image');
        $extension = $request->file('image')->getClientOriginalExtension();
        $fileNameToStore = time() . '.' . $extension;

        //Create thumbnail
        $thumbnail = Image::make($image->getRealPath());
        $thumbnail->resize(150, 150, function ($constraint) {
            $constraint->aspectRatio();
        });
        $thumbnail->stream();

        //store origrinal and thumbnail
        Storage::put('public/companies/' . $company . '/items/small/' . $fileNameToStore, $thumbnail);
        //Storage::put('public/companies/' . $company . '/items', $fileNameToStore, $image);
        $request->file('image')->storeAs('public/companies/' . $company . '/items', $fileNameToStore);

        return $fileNameToStore;
    }


    public static function uploadItemImageUrl(Request $request, $company)
    {

        $path = $request->image_url;

        $fileNameToStore = time() . '.jpg';


        try {
            $image = file_get_contents($path);
            Storage::put('public/companies/' . $company . '/items/' . $fileNameToStore, $image);
            return $fileNameToStore;
        } catch (NotReadableException $e) {
            return $e;
        }
    }

    public static function profile_image($filename)
    {
        return User::PROFILE_DIR . '/' . $filename;
    }

    public static function profile_image_public($filename)
    {
        return User::PROFILE_DIR_PUCLIC . '/' . $filename;
    }

    public static function number_format_short($n, $precision = 1)
    {
        if ($n < 900000) {
            // 0 - 900
            $n_format = number_format($n, $precision, ',', ' ');
            $suffix = '';
        } else if ($n < 900000) {
            // 0.9k-850k
            $n_format = number_format($n / 1000, $precision, ',', ' ');
            $suffix = 'K';
        } else if ($n < 900000000) {
            // 0.9m-850m
            $n_format = number_format($n / 1000000, $precision, ',', ' ');
            $suffix = 'M';
        } else if ($n < 900000000000) {
            // 0.9b-850b
            $n_format = number_format($n / 1000000000, $precision, ',', ' ');
            $suffix = 'B';
        } else {
            // 0.9t+
            $n_format = number_format($n / 1000000000000, $precision, ',', ' ');
            $suffix = 'T';
        }

        // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
        // Intentionally does not affect partials, eg "1.50" -> "1.50"
        if ($precision > 0) {
            $dotzero = '.' . str_repeat('0', $precision);
            $n_format = str_replace($dotzero, '', $n_format);
        }

        return $n_format . $suffix;
    }

    // get payment method
    public static function getPaymentMethod($number): ?string
    {
        if(preg_match("#^097(.*)$#i", $number)) {
            return 'airtel';
        } elseif(preg_match("#^085(.*)$#i", $number)) {
            return 'orange';
        } elseif(preg_match("#^081(.*)$#i", $number)) {
            return 'vodacom';
        }
        return null;
    }

    public static function errorPayment(int $status)
    {
        switch ($status) {
            case 400:
                $this->updatePayment($payment->id, $state[3], 400, $comment);
                return $this->errorResponse($payment, $comment, $status);
                break;
            case 401:
                $this->updatePayment($payment->id, $state[3], 401, $comment);
                return $this->errorResponse($payment, $comment, $status);
                break;
            case 402:
                $this->updatePayment($payment->id, $state[3], 402, $comment);
                return $this->errorResponse($payment, $comment, $status);
                break;
            case 404:
                $this->updatePayment($payment->id, $state[3], 404, $comment);
                return $this->errorResponse($payment, $comment, $status);
                break;
            case 405:
                $this->updatePayment($payment->id, $state[3], 405, $comment);
                return $this->errorResponse($payment, $comment, $status);
                break;
            case 406:
                $this->updatePayment($payment->id, $state[3], 406, $comment);
                return $this->errorResponse($payment, $comment, $status);
                break;
            case 407:
                $this->updatePayment($payment->id, $state[3], 407, $comment);
                return $this->errorResponse($payment, $comment, $status);
                break;
            case 408:
                $this->updatePayment($payment->id, $state[3], 408, $comment);
                return $this->errorResponse($payment, $comment, $status);

                break;
            case 409:
                $this->updatePayment($payment->id, $state[3], 409, $comment);
                return $this->errorResponse($payment, $comment, $status);
                break;
            default:
                $this->updatePayment($payment->id, $state[3], $response->status(), $comment);
                return $this->errorResponse($payment, $comment, $status);

        }
    }

    public static function processingPayment($paymentId, $state, $res_comment, $transaction_id)
    {
        Payment::where('id', $paymentId)->update([
            'attempts' => DB::raw('attempts+1'),
            'state' => $state,
            'transaction_id' => $transaction_id,
            'comment' => "Payment in processing...",
        ]);
        $payment = Payment::where('id', $paymentId)->first();
        if (!$payment->email == null) {
            dispatch(new SendEmailJob(
                $payment->email,
                $payment->email,
                "Uzaraka paiement",
                [
                    'body' => "Vous venez de faire une demande de payment en ligne sur Uzaraka,veullez valider l'achat en entrant votre mot de passe ",
                ]
            ));
        }

        $data = [
            'paymentId' => $payment->id,
            'comment' => "Votre demande est encours de traitement, veuillez valider le payment en entrant votre code PIN",
            "state" => $state,
            'status' => 'Submitted',
            'transaction_id' => $transaction_id,
            'financial_institution_id' => $payment->financial_institution_id,
            "amount" => $payment->amount,
            "currency" => $payment->currency,
            "action" => $payment->action,
            "customer_number" => $payment->customer_number,
            "reference" => $payment->reference,
            "method" => $payment->method,
        ];
        return response()->json($data, 200);
    }

    private function errorResponse($payment, $comment, $code)
    {
        $data = [
            "state" => $payment->state,
            "status" => 'Error',
            "amount" => $payment->amount,
            "currency" => $payment->currency,
            "action" => $payment->action,
            "customer_number" => $payment->customer_number,
            "reference" => $payment->reference,
            "method" => $payment->method,
        ];
        return response()->json($data, $code);
    }
}
