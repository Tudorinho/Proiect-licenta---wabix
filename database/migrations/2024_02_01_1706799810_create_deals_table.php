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
        Schema::create('deals', function (Blueprint $table) {
			$table->id();
			$table->foreignId('user_id')->nullable()->constrained();
			$table->foreignId('companies_contacts_id')->nullable()->constrained();
			$table->foreignId('emails_threads_messages_id')->nullable()->constrained();
			$table->foreignId('deals_statuses_id')->nullable()->constrained();
			$table->foreignId('deals_sources_id')->nullable()->constrained();
			$table->foreignId('currency_id')->nullable()->constrained();
			$table->decimal('deal_size')->default(0);
			$table->enum('type', ['new_deal','upsell'])->default('new_deal');
			$table->string('title');
			$table->text('description')->nullable();
			$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deals');
    }
};
