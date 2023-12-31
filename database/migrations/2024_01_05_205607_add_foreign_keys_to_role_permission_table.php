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
        Schema::table('role_permission', function (Blueprint $table) {
            $table->foreign(['permission_id'], 'role_permission_ibfk_1')->references(['id'])->on('permission')->onDelete('CASCADE');
            $table->foreign(['role_id'], 'role_permission_ibfk_2')->references(['id'])->on('role')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('role_permission', function (Blueprint $table) {
            $table->dropForeign('role_permission_ibfk_1');
            $table->dropForeign('role_permission_ibfk_2');
        });
    }
};
