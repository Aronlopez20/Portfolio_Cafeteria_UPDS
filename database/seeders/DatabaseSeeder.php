<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            RoleSeeder::class,        // Primero crear los roles
            CategorySeeder::class,    // Luego las categorías
            MenuItemSeeder::class,    // Después los items del menú
            UserSeeder::class,        // Finalmente los usuarios con roles
        ]);
    }
}