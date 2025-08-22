<?php
// database/seeders/RoleSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'name' => Role::STUDENT,
                'display_name' => 'Estudiante',
                'description' => 'Usuario estudiante que puede hacer pedidos',
                'icon' => '🎓',
                'permissions' => [
                    'view_menu',
                    'create_order',
                    'view_own_orders',
                    'cancel_own_order',
                    'update_profile',
                ],
                'is_active' => true,
            ],
            [
                'name' => Role::ADMIN,
                'display_name' => 'Administrador',
                'description' => 'Administrador de la cafetería con acceso completo',
                'icon' => '👨‍💼',
                'permissions' => [
                    'view_menu',
                    'manage_menu',
                    'manage_categories',
                    'view_all_orders',
                    'manage_orders',
                    'view_reports',
                    'manage_inventory',
                    'manage_users',
                    'assign_roles',
                    'view_dashboard',
                    'manage_settings',
                ],
                'is_active' => true,
            ],
            [
                'name' => Role::KITCHEN,
                'display_name' => 'Personal de Cocina',
                'description' => 'Personal encargado de preparar y gestionar pedidos',
                'icon' => '👨‍🍳',
                'permissions' => [
                    'view_menu',
                    'view_kitchen_orders',
                    'update_order_status',
                    'mark_order_ready',
                    'mark_order_completed',
                    'view_kitchen_dashboard',
                    'update_item_availability',
                ],
                'is_active' => true,
            ],
        ];

        foreach ($roles as $roleData) {
            Role::create($roleData);
        }
    }
}