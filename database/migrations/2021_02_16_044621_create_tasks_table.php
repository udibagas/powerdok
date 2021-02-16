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
            $table->string('title');
            $table->text('description');
            $table->json('custom_fields')->nullable();
            $table->tinyInteger('priority')->default(0)->comment('0 = low, 1 = medium, 2 = high, 3 = urgent');
            $table->date('due_date')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0 = draft, 1 = submitted, 2 = on progress, 3 = finished, 4 = closed, 5 = void');
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
