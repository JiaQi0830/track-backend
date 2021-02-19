<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnJobProcessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_processes', function (Blueprint $table) {
            $table->renameColumn('process_id', 'job_id');
            $table->renameColumn('step_id', 'process_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_processes', function (Blueprint $table) {
            $table->renameColumn('job_id', 'process_id');
            $table->renameColumn('process_id', 'step_id');
        });
    }
}
