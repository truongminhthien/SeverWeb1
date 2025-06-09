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
        'order_date',
        'total_amount',
        'status',
        'shipping_address',
        'payment_method',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
