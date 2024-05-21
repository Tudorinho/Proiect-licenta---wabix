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
        Schema::create('cold_emailing_rules', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->foreignId('cold_emailing_credentials_id')->constrained();
			$table->string('subject')->nullable();
			$table->datetime('since')->nullable();
			$table->datetime('before')->nullable();
			$table->datetime('last_check_date')->nullable();
			$table->foreignId('user_id')->constrained();
			$table->foreignId('tasks_lists_id')->constrained();
			$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cold_emailing_rules');
    }
};
