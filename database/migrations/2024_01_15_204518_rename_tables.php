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
        if (Schema::hasTable('companies-contacts')) {
            Schema::rename('companies-contacts', 'companies_contacts');
        }

        if (Schema::hasTable('cold-emailing-credentials')) {
            Schema::rename('cold-emailing-credentials', 'cold_emailing_credentials');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
