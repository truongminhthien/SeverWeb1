<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Order extends Model
{
    use HasFactory;


    protected $primaryKey = 'id_order';
    public $incrementing = true;

    protected $fillable = [
        'id_user',
        'total_amount',
        'customer_name',
        'phone',
        'address',
        'payment_method',
        'notes',
        'status',
        'order_date',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'id_order', 'id_order');
    }
}
