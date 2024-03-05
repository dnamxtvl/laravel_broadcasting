<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('user_conversations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->fulltext();
            $table->uuid('conversation_id')->fulltext();
            $table->integer('no_unread_message')->default(0);
            $table->index(['user_id', 'conversation_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('user_conversations');
    }
};
