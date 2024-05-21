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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('project_status_id')->unsigned();
            $table->foreign('project_status_id')->references('id')->on('projects_statuses');
            $table->bigInteger('project_priority_id')->unsigned();
            $table->foreign('project_priority_id')->references('id')->on('projects_priorities');
            $table->bigInteger('project_contract_type_id')->unsigned();
            $table->foreign('project_contract_type_id')->references('id')->on('projects_contracts_types');
            $table->bigInteger('project_source_id')->unsigned();
            $table->foreign('project_source_id')->references('id')->on('projects_sources');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
