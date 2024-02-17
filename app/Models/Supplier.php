<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Model\Category;
use App\Models\Raw;

class Supplier extends Model
{
    use HasFactory;


    public function categorydata()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function raws()
    {
        return $this->belongsToMany(Raw::class);
    }
}
