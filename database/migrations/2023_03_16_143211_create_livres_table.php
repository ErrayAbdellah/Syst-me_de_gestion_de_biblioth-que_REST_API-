<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('livres', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('auteur');
            $table->string('isbn')->unique();
            $table->integer('Nombre_page');
            $table->foreignId('place');
            $table->date('date_publication');
            $table->foreignId('status');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('genre_id')->constrained('genres')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('collection_id')->constrained('collections')->onDelete('cascade')->onUpdate('cascade');
            // $table->foreign('category_id')->references("id")->on("categories")->onDelete("cascade");
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
        Schema::dropIfExists('livres');
    }
};
