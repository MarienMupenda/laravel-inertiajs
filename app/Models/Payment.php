<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;


    private function updatePayment($status, $error_code): bool
    {
           return $this->update([
                'attempts' => DB::raw('attempts+1'),
                'state' => $status,
                'error_code' => $error_code,
            ]);
    }
}
