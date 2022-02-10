<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeatherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weather', function (Blueprint $table) {
            $table->id();

            $table->foreignId('locale_id');

            $table->date('date');
            $table->string('text');
            $table->integer('temperature_min', false, true);
            $table->integer('temperature_max', false, true);
            $table->integer('rain_probability');
            $table->integer('rain_precipitation');

            $table->foreign('locale_id')
                ->references('id')
                ->on('locales')
                ->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weather');
    }
}
