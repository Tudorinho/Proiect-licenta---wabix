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
        Schema::table('tasks', function (Blueprint $table) {
            $table->enum('cold_calling_status', ['none', 'bad_phone_no', 'not_interested', 'interested'])->default('none');
            $table->foreignId('cold_calling_lists_contacts_id')->nullable()->index();
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->foreignId('currency_id')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tables', function (Blueprint $table) {
            //
        });
    }
};
