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
        Schema::create('deals_sources', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->boolean('is_default')->default(0);
			$table->timestamps();
        });

        $sources = [
            'manual',
            'cold_emailing',
            'cold_calling',
        ];
        foreach ($sources as $source){
            \App\Models\DealSource::create([
                'name' => $source,
                'is_default' => 1
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deals_sources');
    }
};
