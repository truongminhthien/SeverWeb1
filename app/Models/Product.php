<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\OrderDetail;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_product';
    public $incrementing = true;

    protected $fillable = [
        'id_category',
        'name',
        'image',
        'price',
        'rating',
        'gender',
        'volume',
        'type',
        'discount',
        'note',
        'description',
        'quantity',
        'views',
        'status',
        'created_at',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category', 'id_category');
    }
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'id_product', 'id_product');
    }
}
