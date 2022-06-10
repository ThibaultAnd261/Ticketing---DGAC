<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('serviceDemandeur');
            $table->string('serviceAffecte');
            $table->string('priorite');
            $table->tinyText('titre');
            $table->longText('description');
            $table->string('telContact');
            $table->string('fileUpload');
            $table->string('status');
            $table->longText('commentaires');
            $table->longText('resolution');
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
        Schema::dropIfExists('tickets');
    }
}
