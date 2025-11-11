<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name','price','photo_path','product_type_id'];

    public function orders()
    {
        return $this->belongsToMany(Order::class)
            ->withPivot(['quantity','unit_price'])
            ->withTimestamps();
    }

    public function type()
    {
        return $this->belongsTo(ProductType::class, 'product_type_id');
    }
}
