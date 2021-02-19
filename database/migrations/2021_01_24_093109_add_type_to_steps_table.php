<?php

use App\Enums\StepType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeToStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('steps', function (Blueprint $table) {
            $table->unsignedSmallInteger('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('steps', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}
