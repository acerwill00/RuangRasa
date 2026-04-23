<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('psychologist_id')->nullable()->after('user_id');
            $table->date('schedule_date')->nullable()->after('psychologist_id');
            $table->time('schedule_time')->nullable()->after('schedule_date');
            $table->string('service_type')->nullable()->after('schedule_time');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['psychologist_id', 'schedule_date', 'schedule_time', 'service_type']);
        });
    }
};
