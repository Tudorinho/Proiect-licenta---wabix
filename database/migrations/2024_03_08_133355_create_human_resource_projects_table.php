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
        Schema::create('human_resource_projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('human_resource_detail_id')->constrained('human_resource_details')->onDelete('cascade');
            $table->string('name');
            $table->string('description');
            $table->json('technologies')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('human_resource_projects');
    }
};
