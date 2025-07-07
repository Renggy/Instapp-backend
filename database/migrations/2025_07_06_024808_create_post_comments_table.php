<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('post_comments', function (Blueprint $table) {
            $table->id('post_comment_id');
            $table->foreignId('post_id')->constrained('posts', 'post_id');
            $table->foreignId('user_id')->constrained('users', 'user_id');
            $table->text('post_comment_text');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_comments');
    }
};
