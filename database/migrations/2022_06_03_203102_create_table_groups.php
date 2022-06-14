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
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            // 0 = Default User, 1 = Moderator??, 2 = Admin etc??
            $table->integer('access_level')->default(0);
            $table->timestamps();
        });

        if (!Schema::hasColumn('users', 'group')) {
            Schema::table('users', function (Blueprint $table) {
                $table->integer('group')->after('remember_token')->default(0);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groups');
    }
};
