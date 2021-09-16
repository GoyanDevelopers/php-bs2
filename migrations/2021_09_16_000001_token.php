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
            $table->string('base_url', 500)->default("https://apihmz.bancobonsucesso.com.br");
            $table->string('api_key', 500);
            $table->string('api_secret', 500);
            $table->string('access_token', 500);
            $table->string('refresh_token', 500);
            $table->string('scope', 500);
            $table->string('status', 500)->default(0);
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
