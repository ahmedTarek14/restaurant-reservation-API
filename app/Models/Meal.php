<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'price',
        'quantity_available',
        'discount',
    ];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}