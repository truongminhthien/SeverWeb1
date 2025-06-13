<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Order;

class OrderDetail extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_order_detail';
    public $incrementing = true;

    protected $fillable = [
        'id_order',
        'id_product',
        'discount',
        'quantity',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'id_order', 'id_order');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }
}
