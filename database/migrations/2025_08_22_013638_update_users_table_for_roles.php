<?php
// Actualizar la migración de users existente
// database/migrations/xxxx_update_users_table_for_roles.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_admin'); // Removemos el campo anterior
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->timestamp('last_login_at')->nullable();
            $table->string('employee_code')->nullable(); // Para empleados
            $table->string('department')->nullable(); // Ej: cafeteria, administracion
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false);
            $table->dropColumn(['status', 'last_login_at', 'employee_code', 'department']);
        });
    }
};