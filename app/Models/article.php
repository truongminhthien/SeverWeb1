<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class article extends Model
{
    use HasFactory;
    protected $table = 'articles';
    protected $primaryKey = 'id_articles';

    protected $fillable = [
        'id_user',
        'title',
        'content',
        'image',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
