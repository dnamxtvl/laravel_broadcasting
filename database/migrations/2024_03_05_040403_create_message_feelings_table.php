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
        Schema::create('message_feelings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('message_id')->fulltext();
            $table->tinyInteger('emoji_id')->index();
            $table->uuid('user_id')->fulltext();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('message_feelings');
    }
};
