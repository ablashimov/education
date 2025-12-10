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
        Schema::create('exam_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->index()->constrained()->cascadeOnDelete();
            $table->foreignId('group_id')->index()->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->index()->constrained()->cascadeOnDelete();
            $table->foreignId('exam_result_status_id')->nullable()->index()->constrained()->nullOnDelete();
            $table->integer('attempts_allowed');
            $table->timestampTz('start_at');
            $table->timestampTz('end_at');
            $table->boolean('is_control');
            $table->unique(['exam_id', 'group_id', 'user_id']);
            $table->timestampsTz();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_assignments');
    }
};
