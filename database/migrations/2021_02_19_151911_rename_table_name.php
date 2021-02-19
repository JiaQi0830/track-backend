<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class RenameTableName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('processes', 'jobs');
        Schema::rename('steps', 'processes');
        Schema::rename('process_steps', 'job_processes');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('jobs', 'processes');
        Schema::rename('processes', 'steps');
        Schema::rename('job_processes', 'process_steps');
    }
}
