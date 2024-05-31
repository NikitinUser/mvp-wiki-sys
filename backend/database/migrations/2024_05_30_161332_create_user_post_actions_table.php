<?php

use App\Enums\UserPostAction;
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
        if (!Schema::hasTable('user_post_actions')) {
            Schema::create('user_post_actions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('id_user');
                $table->unsignedBigInteger('id_post');
                $table->enum('action', UserPostAction::all());
                $table->timestamps();

                $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
                $table->foreign('id_post')->references('id')->on('posts')->onDelete('cascade')->onUpdate('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_post_actions');
    }
};
