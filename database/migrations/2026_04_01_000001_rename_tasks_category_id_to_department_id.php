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
        if (! Schema::hasTable('tasks') || ! Schema::hasColumn('tasks', 'category_id')) {
            return;
        }

        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->dropUnique(['title', 'due_date']);
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->renameColumn('category_id', 'department_id');
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->foreign('department_id')->references('id')->on('departments')->cascadeOnDelete();
            $table->unique(['department_id', 'title', 'due_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('tasks') || ! Schema::hasColumn('tasks', 'department_id')) {
            return;
        }

        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->dropUnique(['department_id', 'title', 'due_date']);
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->renameColumn('department_id', 'category_id');
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('departments')->cascadeOnDelete();
            $table->unique(['title', 'due_date']);
        });
    }
};
