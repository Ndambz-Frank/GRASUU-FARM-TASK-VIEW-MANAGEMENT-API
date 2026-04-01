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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('department_id')->constrained('departments')->cascadeOnDelete();
            $table->date('due_date');
            $table->time('due_time');
            $table->enum('priority', ['Low', 'Medium', 'High']);
            $table->enum('status', ['Pending', 'In-Progress', 'Done'])->default('Pending');
            $table->timestamps();
            $table->unique(['department_id', 'title', 'due_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
