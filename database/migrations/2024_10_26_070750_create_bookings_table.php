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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->date('order_date');
            $table->enum('status', ['accept', 'pending', 'failed', 'canceled']);
            $table->string('uploud_payment')->nullable();
            $table->foreignId('rented_by')->constrained('user')->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('approved_by')->nullable()->constrained('user')->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('id_voucher')->nullable()->constrained('vouchers')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('user_info')->nullable()->constrained('user_infos')->onUpdate('restrict')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
