<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->text('slug');
            $table->json('tags')->nullable();
            $table->json('categories')->nullable();
            $table->string('number');
            $table->string('version');
            $table->json('departments')->nullable();
            $table->date('effective_date')->nullable();
            $table->date('expired_date')->nullable();
            $table->unsignedBigInteger('owner_id');
            $table->json('favourites');
            $table->tinyInteger('type')->default(0); // SOP or Policy
            $table->boolean('is_public')->default(false);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();

            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
