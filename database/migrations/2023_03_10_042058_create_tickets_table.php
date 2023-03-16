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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('title');
            $table->longText('description');
            $table->enum('priority', ['low', 'medium', 'high']);
            $table->enum('status', ['waiting', 'in_progress', 'done', 'cancelled'])->default('waiting');
            $table->foreignId('category_id')->nullable()->constrained('categories');
            $table->dateTime('due_date')->nullable();
            $table->text('files')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
