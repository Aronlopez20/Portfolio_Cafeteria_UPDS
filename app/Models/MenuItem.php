<?php
// app/Models/MenuItem.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'available_quantity',
        'is_available',
        'is_vegetarian',
        'is_vegan',
        'preparation_time',
        'category_id'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_available' => 'boolean',
        'is_vegetarian' => 'boolean',
        'is_vegan' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function scopeAvailable($query)
    {
        return $query->where('is_available', true)->where('available_quantity', '>', 0);
    }

    public function getFormattedPriceAttribute()
    {
        return 'Bs. ' . number_format($this->price, 2);
    }
}