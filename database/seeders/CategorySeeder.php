<?php

// database/seeders/CategorySeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Desayunos',
                'description' => 'Opciones deliciosas para empezar el día',
                'icon' => '🌅',
                'is_active' => true
            ],
            [
                'name' => 'Almuerzos',
                'description' => 'Platos principales y completos',
                'icon' => '🍽️',
                'is_active' => true
            ],
            [
                'name' => 'Bebidas',
                'description' => 'Refrescos, jugos y bebidas calientes',
                'icon' => '🥤',
                'is_active' => true
            ],
            [
                'name' => 'Snacks',
                'description' => 'Bocadillos y comida rápida',
                'icon' => '🍿',
                'is_active' => true
            ],
            [
                'name' => 'Postres',
                'description' => 'Dulces delicias para endulzar tu día',
                'icon' => '🧁',
                'is_active' => true
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}