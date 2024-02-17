<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Product;
use App\Models\Category;

class Prefeneces extends Authenticatable
{
    use  HasFactory, Notifiable;

    protected $table='preference';

public function productData(){
    return $this->belongsTo(Product::class,'pro_id','id');
}
public function categoryData(){
    return $this->belongsTo(Category::class,'cate_id','id');
}



}
