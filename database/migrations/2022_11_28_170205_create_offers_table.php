<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->char('mark', 254)->nullable()->index('mark');
            $table->char('model' , 254)->nullable()->index('model');
            $table->char('generation' , 254)->nullable()->index('generation');
            $table->unsignedSmallInteger('year' )->nullable()->index('year');
            $table->unsignedInteger('run')->nullable()->index('run');
            $table->char('color' , 254)->nullable()->index('color');
            $table->char('body-type' , 254)->nullable()->index('body-type');
            $table->char('engine-type' , 254)->nullable()->index('engine-type');
            $table->char('transmission' , 254)->nullable()->index('transmission');
            $table->char('gear-type' , 254)->nullable()->index('gear-type');
            $table->unsignedBigInteger('generation_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
}
