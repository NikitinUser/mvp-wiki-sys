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
        if (!Schema::hasTable('posts')) {
            Schema::create('posts', function (Blueprint $table) {
                $table->id();
                $table->uuid('post_number');
                $table->unsignedBigInteger('created_by')->nullable();
                $table->string('title', 500);
                $table->string('content', 500);
                $table->integer('version')->default(1);
                $table->boolean('is_active')->default(true);
                $table->timestamps();

                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
                $table->index('post_number');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
