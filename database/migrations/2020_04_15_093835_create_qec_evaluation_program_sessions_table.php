<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQecEvaluationProgramSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qec_evaluation_program_sessions', function (Blueprint $table) {
            $table->id();
            $table->integer('qec_evaluation_id');
            $table->integer('program_session_id');
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
        Schema::dropIfExists('qec_evaluation_program_sessions');
    }
}
