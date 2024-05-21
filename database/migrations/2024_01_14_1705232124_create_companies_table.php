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
        Schema::create('companies', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->string('registration_number')->nullable();
			$table->string('address_line_1')->nullable();
			$table->string('address_line_2')->nullable();
			$table->enum('type', ['lead','prospect','customer','supplier'])->default('lead');
			$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
