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
    public function up()
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->string('model_type');
            $table->unsignedBigInteger('model_id');

            $table->primary(['id', 'model_type', 'model_id']);
        });

        Schema::create('messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('role');
            $table->text('content');
            $table->unsignedBigInteger('chat_id');
            $table->foreign('chat_id')
                ->references('id')
                ->on('chats')
                ->onDelete('cascade');
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
        Schema::dropIfExists('chats');
        Schema::dropIfExists('messages');
    }
};
