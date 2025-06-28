<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use Cviebrock\EloquentSluggable\Sluggable;

class Category extends Model
{
    use HasFactory;
    use Sluggable;


    protected $primaryKey = 'id_category';
    public $incrementing = true;

    protected $fillable = [
        'category_name',
        'category_image',
        'id_parent',
        'slug',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'category_name'
            ]
        ];
    }

    public function subcategory()
    {
        return $this->hasMany(Category::class, 'id_parent', 'id_category');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'id_category', 'id_category');
    }
}
