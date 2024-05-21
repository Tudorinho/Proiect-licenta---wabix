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
        Schema::create('leaves', function (Blueprint $table) {
			$table->id();
			$table->foreignId('employee_id')->constrained();
			$table->foreignId('leaves_types_id')->constrained();
			$table->enum('status', ['pending','approved','rejected'])->default('pending');
			$table->dateTime('start_date');
			$table->dateTime('end_date');
			$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};
