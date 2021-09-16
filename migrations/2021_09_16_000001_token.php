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
            $table->string('access_token', 500)->nullable()->default(null);
            $table->string('refresh_token', 500)->nullable()->default(null);
            $table->string('scope', 500)->nullable()->default(null);
            $table->string('status', 500)->default(0);
        });

        (new Goyan\Bs2\Models\Token)->setConnection(config('bs2.database_connection'))->create([
            'status' => 0,
        ]);
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
