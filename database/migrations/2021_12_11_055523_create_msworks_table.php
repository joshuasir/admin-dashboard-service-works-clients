<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMsworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('msworks', function (Blueprint $table) {
            $table->increments('WorkID');
            $table->string('Tag');
            $table->string('Source');
            $table->string('Category');
            $table->string('Link');
            $table->string('Type');
            $table->boolean('Highlight')->defaults(0);
            $table->boolean('Visible')->defaults(1);
            $table->timestamp('LastUpdated');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('msworks');
    }
}
