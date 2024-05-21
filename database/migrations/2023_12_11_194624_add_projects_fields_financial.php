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
        Schema::table('projects', function (Blueprint $table) {
            $table->foreignId('currency_id')->nullable()->constrained();
            $table->decimal('flat_estimated_value', 20, 10)->default(0);
            $table->decimal('flat_negotiated_value', 20, 10)->default(0);
            $table->decimal('flat_accepted_value', 20, 10)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
