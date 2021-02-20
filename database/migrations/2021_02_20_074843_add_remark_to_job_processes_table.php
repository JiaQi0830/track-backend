<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRemarkToJobProcessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_processes', function (Blueprint $table) {
            $table->string('remark')->after('completed_date');
            $table->string('file_path')->after('remark');
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
            $table->dropColumn('remark');
            $table->dropColumn('file_path');
        });
    }
}
