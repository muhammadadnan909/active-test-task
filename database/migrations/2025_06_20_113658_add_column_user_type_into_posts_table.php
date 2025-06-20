<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnUserTypeIntoPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            //
            $table->enum('role', ['admin', 'user'])->default('user')->after('user_id');

        });
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn('role');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            //
            $table->dropColumn('role');

        });
        Schema::table('users', function (Blueprint $table): void {
            //
            $table->enum('role', ['admin', 'user'])->default('user')->after('email');

        });
    }
}
