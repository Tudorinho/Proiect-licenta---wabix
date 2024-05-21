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
        Schema::create('human_resource_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('human_resource_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->date('start');
            $table->date('end')->nullable();
            $table->string('type');
            $table->boolean('is_academic');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('human_resource_details');
    }
};
