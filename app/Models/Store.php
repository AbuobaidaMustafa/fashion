<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Item;

class Store extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id','area_id','name', 'name_local', 'phone', 'image','location'
    ];

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
