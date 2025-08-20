<?php
// database/seeders/DatabaseSeeder.php (modificar)
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            CategorySeeder::class,
            MenuItemSeeder::class,
            UserSeeder::class,
        ]);
    }
}