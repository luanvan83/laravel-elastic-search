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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('publisher', 128);
            $table->string('title', 128);
            $table->text('summary');
            $table->timestamps();

            $table->index(['publisher', 'title']);
            $table->fullText('summary');
        });

        Schema::create('book_author', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('book_id');
            $table->bigInteger('author_id');
            $table->index(['book_id', 'author_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_author');
        Schema::dropIfExists('books');
    }
};
