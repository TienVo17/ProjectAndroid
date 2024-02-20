<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Checkinout;
use App\Models\BookingRoom;
use App\Models\Invoice;


class Customer extends Model
{
    protected $table = 'customer';
    
    public function checkin_out() {
        return $this->hasMany(Checkinout::class);
    }

    public function booking_room() {
        return $this->hasMany(BookingRoom::class);
    }

    public function invoice() {
        return $this->hasMany(Invoice::class);
    }
}
