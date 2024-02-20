<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('book_room', function (Blueprint $table) {
            $table->id();
            $table->integer('room_id');
            $table->integer('customer_id');
            $table->timestamp('check_in_date')->nullable();
            $table->timestamp('check_out_date')->nullable();
            $table->timestamp('booking_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_room');
    }
};
