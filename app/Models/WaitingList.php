<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaitingList extends Model
{
    use HasFactory;

    protected $table = 'waiting_list';

    protected $fillable = [
        'customer_id',
        'added_at',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}