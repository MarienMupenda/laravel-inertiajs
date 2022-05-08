<?php

namespace App\Helpers;

use App\Jobs\SendEmailJob;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Exception\NotReadableException;
use Intervention\Image\Facades\Image;


class Helpers
{

    public static function error()
    {
        return abort(404);
    }

}
