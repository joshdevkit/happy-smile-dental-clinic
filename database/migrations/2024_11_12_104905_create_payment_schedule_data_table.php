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
        Schema::create('payment_schedule_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_schedule_id');
            $table->enum('payment_method', ['Cash', 'Online']);
            $table->longText('remarks');
            $table->date('payment_date');
            $table->timestamps();

            $table->foreign('client_schedule_id')->references('id')->on('client_schedules')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_schedule_data');
    }
};
