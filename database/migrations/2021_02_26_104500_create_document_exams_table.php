<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_exams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('document_id');
            $table->json('quizzes');
            $table->smallInteger('exam_minimum_score')->default(0);
            $table->smallInteger('exam_max_duration')->nullable();
            $table->dateTime('time_start')->nullable();
            $table->dateTime('time_finished')->nullable();
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
        Schema::dropIfExists('document_exams');
    }
}
