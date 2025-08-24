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
        Schema::create('path_problems', function (Blueprint $table) {
            $table->id();
            $table->foreignId('path_id')->constrained('learning_paths')->onDelete('cascade');
            $table->foreignId('problem_id')->constrained('problems')->onDelete('cascade');
            $table->integer('order')->default(0);
            $table->boolean('is_required')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('path_problems');
    }
};
