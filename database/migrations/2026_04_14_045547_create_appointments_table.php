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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('order_id'); // foreign key to orders.id
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('psychologist_id')->constrained()->cascadeOnDelete();
            $table->date('schedule_date');
            $table->time('schedule_time');
            $table->text('notes')->nullable();
            $table->string('status')->default('scheduled'); // scheduled, completed, canceled
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
