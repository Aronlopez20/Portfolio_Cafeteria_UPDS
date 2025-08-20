<?php
// app/Http/Controllers/MenuController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuItem;
use App\Models\Category;

class MenuController extends Controller
{
    public function index()
    {
        $categories = Category::active()->with(['menuItems' => function($query) {
            $query->available();
        }])->get();

        return view('menu.index', compact('categories'));
    }

    public function show(MenuItem $menuItem)
    {
        return view('menu.show', compact('menuItem'));
    }
}
