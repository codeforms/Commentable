<?php


use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Kalnoy\Nestedset\NestedSet;

class CreateCommentsTable extends Migration
{
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->text('body');
            $table->morphs('commentable');
            $table->integer('user_id')->unsigned();
            $table->integer('parent_id')->unsigned();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('parent_id')
                ->references('id')
                ->on('comments')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
