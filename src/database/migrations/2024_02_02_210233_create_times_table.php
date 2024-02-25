<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('times', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->dateTime('punchIn');
            $table->dateTime('punchOut')->nullable();
            $table->Time('workTime')->nullable();
            $table->Time('totalBreakTime')->default('00:00:00');
            $table->boolean('workStartButtonState')->nullable();
            $table->boolean('workEndButtonState')->nullable();
            $table->boolean('breakStartButtonState')->nullable();
            $table->boolean('breakEndButtonState')->nullable();
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
        Schema::dropIfExists('times');
    }
}
