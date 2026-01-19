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
        Schema::create('list_bookings', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('session');
            $table->foreignId('id_field')->constrained('fields')->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('id_booking')->constrained('bookings')->onUpdate('restrict')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_bookings');
    }
};
