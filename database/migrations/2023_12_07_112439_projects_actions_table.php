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
        Schema::create('projects_actions', function (Blueprint $table) {
            $table->id();
            $table->text('description')->nullable();
            $table->enum('status', ['not_started', 'in_progress', 'done'])->default('not_started');
            $table->dateTime('due_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->bigInteger('project_id')->unsigned();
            $table->foreign('project_id')->references('id')->on('projects');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects_actions');
    }
};
