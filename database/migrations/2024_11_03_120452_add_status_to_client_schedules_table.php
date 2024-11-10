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
        Schema::table('client_schedules', function (Blueprint $table) {
            $table->enum('status', ['Pending', 'Success', 'Confirmed', 'Cancelled', 'Not Attended'])->default('Pending')->after('walk_in_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_schedules', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
