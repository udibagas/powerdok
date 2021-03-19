<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('Creator');
            $table->tinyInteger('type')->comment('1 = document review, 2 = atestation, 3 = examination');
            $table->unsignedBigInteger('document_id')->nullable();
            $table->unsignedBigInteger('assignee_id')->nullable();
            $table->string('title');
            $table->text('description');
            $table->json('custom_fields')->nullable();
            $table->tinyInteger('priority')->default(0)->comment('0 = low, 1 = medium, 2 = high, 3 = urgent');
            $table->date('due_date')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0 = submitted, 1 = on progress, 2 = finalized, 3 = approval, 4 = partially approved, 5 = approved, 6 = finished, 7 = closed, 8 = void, 9 = postponed');
            $table->softDeletes();
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
        Schema::dropIfExists('tasks');
    }
}
