<?php
// app/Http/Controllers/CategoryController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        $menuItems = $category->menuItems()->available()->get();
        return view('categories.show', compact('category', 'menuItems'));
    }
}