<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->after('name')->length(20)->unique();
            $table->string('otp')->after('email')->length(6)->nullable();
            $table->string('user_role')->default('user')->after('password');
            $table->string('avatar')->nullable()->after('user_role');
            $table->timestamp('registered_at')->nullable()->after('remember_token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('username');
            $table->dropColumn('otp');
            $table->dropColumn('user_role');
            $table->dropColumn('avatar');
            $table->dropColumn('registered_at');
        });
    }
}
