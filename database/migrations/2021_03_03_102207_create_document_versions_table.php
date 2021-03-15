<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_versions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('document_id');
            $table->string('number')->nullable();
            $table->string('version')->nullable();
            $table->date('effective_date')->nullable();
            $table->date('expired_date')->nullable();
            $table->unsignedBigInteger('owner_id');
            $table->text('body');
            $table->tinyInteger('status')->default(0)->comment('0 = draft, 1 = on review, 2 = approve, 3 = publish, 4 = void, 5 = archive');
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
        Schema::dropIfExists('document_versions');
    }
}
