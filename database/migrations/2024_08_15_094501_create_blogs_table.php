<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title' );
            $table->string('slug');
            $table->text('short_desc');
            $table->text('long_desc');
            $table->string('main_img')->nullable();
            $table->string('multiple_img')->nullable();
            $table->string('author')->nullable();
            $table->string('category')->nullable();
            
            $table->string('meta_title')->nullable();
            $table->text('meta_desc')->nullable();
            $table->text('meta_keyword')->nullable();
            $table->text('meta_image')->nullable();
            
            
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
        Schema::dropIfExists('blogs');
    }
}
