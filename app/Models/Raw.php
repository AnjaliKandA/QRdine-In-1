<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Model\Category;
use App\Models\Supplier;

class Raw extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'supplier_id',
        'name',
        'description',
        'price',
        'quantity',
        'created_at',
    ];

    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
