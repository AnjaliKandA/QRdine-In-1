<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Order;


class Table extends Model
{
    protected $table = 'tables';

    protected $casts = [
        'number' => 'integer'
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function order(): HasMany
    {
        return $this->hasMany(Order::class, 'table_id', 'id');
    }

    public function table_order(): HasMany
    {
        return $this->hasMany(TableOrder::class, 'table_id', 'id');
    }
    

    public  function orderstatus(){
        return $this->belongsTo(Order::class, 'id', 'table_id');

    }
}
