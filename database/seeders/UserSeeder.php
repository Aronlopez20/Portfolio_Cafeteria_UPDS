<?php
// database/seeders/UserSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin user
        User::create([
            'name' => 'Admin UPDS',
            'email' => 'admin@upds.edu.bo',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        // Usuario de prueba - Luciana (Scrum Master)
        User::create([
            'name' => 'Luciana Zapana',
            'email' => 'luciana@upds.edu.bo',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'student_code' => '202100001',
            'phone' => '70000001',
            'is_admin' => false,
        ]);

        // Usuario estudiante de prueba
        User::create([
            'name' => 'Camila Torres',
            'email' => 'camila@upds.edu.bo',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'student_code' => '202100002',
            'phone' => '70000002',
            'is_admin' => false,
        ]);
    }
}
