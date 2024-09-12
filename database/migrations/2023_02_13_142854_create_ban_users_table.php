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
        Schema::create('ban_users', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->contrained('users');
            $table->boolean('is_ban');
            $table->timestamp('ban_date')->nullable();
            $table->timestamp('unban_date')->nullable();
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
        Schema::dropIfExists('ban_users');
    }
};
