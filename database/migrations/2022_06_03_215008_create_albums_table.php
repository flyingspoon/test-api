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
        Schema::create('albums', function (Blueprint $table) {
            $table->id();

            /**
             * Slug
             * Album Title
             * Album Bio
             * Album Genres [..., ...]
             * Artist ID
             */

            $table->string('slug')->nullable(false);
            $table->string('title')->nullable(false);
            $table->longText('bio')->nullable(true);
            $table->json('genres')->nullable(true);
            $table->integer('artist')->nullable(false);

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
        Schema::dropIfExists('albums');
    }
};
