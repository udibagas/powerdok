<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_forms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('owner_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->json('fields');
            $table->json('approvals')->nullable();
            $table->boolean('published')->default(false);
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
        Schema::dropIfExists('master_forms');
    }
}
