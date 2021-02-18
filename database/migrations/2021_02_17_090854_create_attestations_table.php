<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttestationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attestations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('document_id');
            $table->date('due_date')->nullable();
            $table->boolean('status')->default(true)->comment('true = open, false = closed');
            $table->unsignedBigInteger('user_id')->comment('creator');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attestations');
    }
}
