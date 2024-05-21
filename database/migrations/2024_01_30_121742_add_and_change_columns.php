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
        Schema::table('companies_contacts', function (Blueprint $table) {
            $table->string('phone')->nullable();
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->string('website')->nullable();
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->enum('type', ['manual', 'cold_emailing', 'cold_calling'])->default('manual')->change();
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
