<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('slots', function (Blueprint $table) {
            $table->increments('id');
            $table->date('slot_date');
            $table->time('slot_fromtime');
            $table->time('slot_totime');
            $table->text('slot_desc');
            $table->integer('slot_duration',11)->default(0);
            $table->integer('no_of_joinee',11);
            $table->integer('status',2)->default(1);
            $table->tinyInteger('prior_status',4)->default(0);
            $table->integer('created_by',10)->default(0);
            $table->integer('updated_by',11)->default(0);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(0000-00-00 00:00:00);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('slots');
    }
}
