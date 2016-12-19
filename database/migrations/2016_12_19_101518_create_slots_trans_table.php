<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlotsTransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slots_trans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('slot_id',11);
            $table->integer('status',11)->default(1);
            $table->varchar('comments',255);
            $table->integer('created_by',10);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('slots_trans');
    }
}
