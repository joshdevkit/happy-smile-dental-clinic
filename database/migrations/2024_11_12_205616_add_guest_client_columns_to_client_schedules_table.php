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
            $table->boolean('is_guest')->default(false)->after('walk_in_name');
            $table->string('guest_name')->nullable()->after('is_guest');
            $table->string('guest_contact')->nullable()->after('guest_name');
            $table->string('guest_email')->nullable()->after('guest_contact');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_schedules', function (Blueprint $table) {
            $table->dropColumn(['is_guest', 'guest_name', 'guest_contact', 'guest_email']);
        });
    }
};
