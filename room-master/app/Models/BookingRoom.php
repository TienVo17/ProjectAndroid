<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\Room;

class BookingRoom extends Model
{
    protected $table = 'book_room';

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function room() {
        return $this->belongsTo(Room::class);
    }
}
