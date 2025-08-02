<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class Voucher extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_voucher';
    public $incrementing = true;

    protected $fillable = [
        'code',
        'discount_amount',
        'start_date',
        'end_date',
        'min_order_amount',
        'max_discount_amount',
        'usage_limit',
        'description',
        'note',
        'type',
        'status'
    ];
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];
    /**
     * Get the orders associated with the voucher.
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'id_voucher', 'id_voucher');
    }
}
