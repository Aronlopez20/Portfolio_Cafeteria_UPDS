<?php


// database/migrations/xxxx_add_fields_to_users_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable();
            $table->string('student_code')->nullable();
            $table->string('google_id')->nullable();
            $table->string('avatar')->nullable();
            $table->boolean('is_admin')->default(false);
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'student_code', 'google_id', 'avatar', 'is_admin']);
        });
    }
};
