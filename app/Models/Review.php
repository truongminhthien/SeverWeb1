<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $table = 'reviews';
    protected $primaryKey = 'id_review';
    protected $fillable = [
        'id_user',
        'id_product',
        'rating',
        'content',
        'created_date'
    ];
    public $timestamps = true;
    protected $casts = [
        'created_date' => 'datetime',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }
}
