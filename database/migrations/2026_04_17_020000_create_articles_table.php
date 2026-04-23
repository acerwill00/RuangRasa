<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category');           // e.g. 'anxiety'
            $table->string('category_label');     // e.g. 'Anxiety'
            $table->string('image')->nullable();  // URL
            $table->text('excerpt');
            $table->longText('content');
            $table->string('author');
            $table->string('date');               // display string e.g. 'Oct 12'
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
