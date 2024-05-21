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
        Schema::create('emails_threads_messages', function (Blueprint $table) {
			$table->id();
			$table->foreignId('emails_threads_id')->constrained();
			$table->longText('subject')->nullable();
			$table->longText('message')->nullable();
			$table->datetime('date')->nullable();
			$table->string('from')->nullable();
			$table->string('to')->nullable();
			$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emails_threads_messages');
    }
};
