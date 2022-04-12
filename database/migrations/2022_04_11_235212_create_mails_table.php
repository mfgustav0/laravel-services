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
        Schema::create('mails', function (Blueprint $table) {
            $table->id();

            $table->string('database')->nullable();
            $table->json('sale');
            $table->json('client');
            $table->string('type');
            $table->text('observation')->nullable();
            $table->enum('status', [0, 1, 2]);
            $table->timestamp('sended_at', $precision = 0)->nullable();
            $table->timestamp('last_sended_at', $precision = 0)->nullable();
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
        Schema::dropIfExists('mails');
    }
};
