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
            $table->json('departments')->nullable();
            $table->json('favourites')->nullable();
            $table->tinyInteger('type')->default(0); // SOP or Policy
            $table->boolean('is_public')->default(false);
            $table->smallInteger('exam_minimum_score')->nullable()->comment('untuk menentukan nilai minimal exam');
            $table->smallInteger('exam_max_duration')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
