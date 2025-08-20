<?php
// database/seeders/MenuItemSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuItem;
use App\Models\Category;

class MenuItemSeeder extends Seeder
{
    public function run()
    {
        $desayunosId = Category::where('name', 'Desayunos')->first()->id;
        $almuerzosId = Category::where('name', 'Almuerzos')->first()->id;
        $bebidasId = Category::where('name', 'Bebidas')->first()->id;
        $snacksId = Category::where('name', 'Snacks')->first()->id;
        $postresId = Category::where('name', 'Postres')->first()->id;

        $menuItems = [
            // Desayunos
            [
                'name' => 'Desayuno UPDS Completo 🍳',
                'description' => 'Huevos fritos, pan tostado, queso y mermelada',
                'price' => 25.00,
                'available_quantity' => 20,
                'is_available' => true,
                'preparation_time' => 10,
                'category_id' => $desayunosId,
            ],
            [
                'name' => 'Café con Leche y Tostadas ☕',
                'description' => 'Café recién hecho con leche y tostadas con mantequilla',
                'price' => 15.00,
                'available_quantity' => 30,
                'is_available' => true,
                'preparation_time' => 5,
                'category_id' => $desayunosId,
            ],
            
            // Almuerzos
            [
                'name' => 'Almuerzo Ejecutivo 🍛',
                'description' => 'Arroz, pollo a la plancha, ensalada y sopa',
                'price' => 35.00,
                'available_quantity' => 25,
                'is_available' => true,
                'preparation_time' => 20,
                'category_id' => $almuerzosId,
            ],
            [
                'name' => 'Hamburguesa UPDS 🍔',
                'description' => 'Hamburguesa casera con papas fritas',
                'price' => 30.00,
                'available_quantity' => 15,
                'is_available' => true,
                'preparation_time' => 15,
                'category_id' => $almuerzosId,
            ],
            [
                'name' => 'Plato Vegetariano 🥗',
                'description' => 'Quinoa, verduras salteadas y aguacate',
                'price' => 28.00,
                'available_quantity' => 10,
                'is_available' => true,
                'is_vegetarian' => true,
                'is_vegan' => true,
                'preparation_time' => 15,
                'category_id' => $almuerzosId,
            ],
            
            // Bebidas
            [
                'name' => 'Jugo Natural 🥤',
                'description' => 'Jugo fresco de temporada',
                'price' => 12.00,
                'available_quantity' => 40,
                'is_available' => true,
                'preparation_time' => 3,
                'category_id' => $bebidasId,
            ],
            [
                'name' => 'Café Americano ☕',
                'description' => 'Café negro recién preparado',
                'price' => 8.00,
                'available_quantity' => 50,
                'is_available' => true,
                'preparation_time' => 2,
                'category_id' => $bebidasId,
            ],
            [
                'name' => 'Té de Coca 🍃',
                'description' => 'Té tradicional boliviano',
                'price' => 6.00,
                'available_quantity' => 30,
                'is_available' => true,
                'preparation_time' => 3,
                'category_id' => $bebidasId,
            ],
            
            // Snacks
            [
                'name' => 'Empanadas Salteñas 🥟',
                'description' => 'Empanadas tradicionales bolivianas (2 unidades)',
                'price' => 20.00,
                'available_quantity' => 24,
                'is_available' => true,
                'preparation_time' => 5,
                'category_id' => $snacksId,
            ],
            [
                'name' => 'Sándwich Mixto 🥪',
                'description' => 'Pan, jamón, queso y lechuga',
                'price' => 18.00,
                'available_quantity' => 15,
                'is_available' => true,
                'preparation_time' => 8,
                'category_id' => $snacksId,
            ],
            
            // Postres
            [
                'name' => 'Helado de Canela 🍦',
                'description' => 'Helado tradicional de canela',
                'price' => 10.00,
                'available_quantity' => 20,
                'is_available' => true,
                'preparation_time' => 2,
                'category_id' => $postresId,
            ],
            [
                'name' => 'Torta de Chocolate 🍰',
                'description' => 'Porción de torta casera de chocolate',
                'price' => 15.00,
                'available_quantity' => 12,
                'is_available' => true,
                'preparation_time' => 3,
                'category_id' => $postresId,
            ],
        ];

        foreach ($menuItems as $item) {
            MenuItem::create($item);
        }
    }
}