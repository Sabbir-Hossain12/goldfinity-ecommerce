<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            
            $table->string('ip_address');
            $table->string('browser')->nullable();
            $table->tinyInteger('is_visited')->default(1);
            $table->date('date')->nullable();
            $table->string('month')->nullable();
            $table->string('year')->nullable();

            $table->tinyInteger('status')->default(1);


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
        Schema::dropIfExists('visitors');
    }
}
