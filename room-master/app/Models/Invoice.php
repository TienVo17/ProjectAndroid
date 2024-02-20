<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\Method;
use App\Models\Checkinout;


class Invoice extends Model
{
    protected $table = 'invoice';

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function checkinout() {
        return $this->belongsTo(Checkinout::class);
    }
}
