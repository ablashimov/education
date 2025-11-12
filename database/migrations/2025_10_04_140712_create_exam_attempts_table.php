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
        Schema::create('exam_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_instance_id')->index()->constrained()->cascadeOnDelete();
            $table->timestampTz('started_at');
            $table->timestampTz('submitted_at')->nullable();
            $table->integer('elapsed_seconds')->nullable();
            $table->integer('score')->nullable();
            $table->foreignId('graded_by')->nullable()->index()->constrained('users')->nullOnDelete();
            $table->jsonb('client_info');
            $table->ipAddress('ip');
            $table->timestampsTz();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_attempts');
    }
};
