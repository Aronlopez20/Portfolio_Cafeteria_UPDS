<?php
// app/Models/Order.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Estados constantes
    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_READY = 'ready';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'order_number',
        'user_id',
        'total_amount',
        'status',
        'payment_status',
        'scheduled_for',
        'special_notes'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'scheduled_for' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // -----------------------------
// RELACIÓN orderItems
// Esto permite al modelo Order acceder a sus items con $order->orderItems
// Necesario para la API de factura y la vista HTML
// -----------------------------
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getFormattedTotalAttribute()
    {
        return 'Bs. ' . number_format($this->total_amount, 2);
    }

    public static function generateOrderNumber()
    {
        return 'UPDS-' . date('Ymd') . '-' . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
    }

    // Scopes para diferentes estados
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', self::STATUS_CONFIRMED);
    }

    public function scopeReady($query)
    {
        return $query->where('status', self::STATUS_READY);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    // Métodos de estado
    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isConfirmed()
    {
        return $this->status === self::STATUS_CONFIRMED;
    }

    public function isReady()
    {
        return $this->status === self::STATUS_READY;
    }

    public function isCompleted()
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function isCancelled()
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    // Método para obtener el color del estado
    public function getStatusColorAttribute()
    {
        $colors = [
            self::STATUS_PENDING => 'yellow',
            self::STATUS_CONFIRMED => 'blue',
            self::STATUS_READY => 'green',
            self::STATUS_COMPLETED => 'gray',
            self::STATUS_CANCELLED => 'red'
        ];

        return $colors[$this->status] ?? 'gray';
    }

    // Método para obtener el texto del estado
    public function getStatusTextAttribute()
    {
        $texts = [
            self::STATUS_PENDING => 'Pendiente',
            self::STATUS_CONFIRMED => 'En Preparación',
            self::STATUS_READY => 'Listo',
            self::STATUS_COMPLETED => 'Entregado',
            self::STATUS_CANCELLED => 'Cancelado'
        ];

        return $texts[$this->status] ?? 'Desconocido';
    }
}
