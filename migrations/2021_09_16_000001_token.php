<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Token extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(config('bs2.database_connection'))->create('Token', function (Blueprint $table) {
            $table->id();
            $table->string('access_token', 500)->nullable();
            $table->string('refresh_token', 500)->nullable();
            $table->string('scope', 500)->nullable();
            $table->boolean('status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(config('bs2.database_connection'))->dropIfExists('Token');
    }
}
