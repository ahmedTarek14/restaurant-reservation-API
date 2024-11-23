<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    protected $fillable = [
        'capacity',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}