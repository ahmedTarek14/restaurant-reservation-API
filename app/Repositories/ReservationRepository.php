<?php

namespace App\Repositories;

use App\Models\Table;

class ReservationRepository
{
    public $model;

    public function __construct(Table $model)
    {
        $this->model = $model;
    }
    /**
     * Find an available table based on guest capacity and reservation times.
     */
    public function findAvailableTable($numberOfGuests, $startTime, $endTime)
    {
        return $this->model->where('capacity', '>=', $numberOfGuests)
            ->whereDoesntHave('reservations', function ($query) use ($startTime, $endTime) {
                $query->whereBetween('from_time', [$startTime, $endTime])
                    ->orWhereBetween('to_time', [$startTime, $endTime])
                    ->orWhere(function ($q) use ($startTime, $endTime) {
                        $q->where('from_time', '<=', $startTime)
                            ->where('to_time', '>=', $endTime);
                    });
            })
            ->first();
    }
}