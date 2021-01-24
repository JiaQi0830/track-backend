<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompletedByInProcessStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('process_steps', function (Blueprint $table) {
            $table->unsignedSmallInteger('completed_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('process_steps', function (Blueprint $table) {
            $table->dropColumn('completed_by');
        });
    }
}
