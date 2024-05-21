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
        Schema::create('leaves_balances', function (Blueprint $table) {
			$table->id();
			$table->foreignId('employee_id')->constrained();
			$table->foreignId('leaves_types_id')->constrained();
			$table->integer('balance');
			$table->string('year');
			$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaves_balances');
    }
};
