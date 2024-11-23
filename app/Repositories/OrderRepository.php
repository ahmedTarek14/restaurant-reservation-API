<?php

namespace App\Repositories;

use App\Models\Meal;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Collection;

class OrderRepository
{
    public $model;

    public function __construct(Order $model)
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(Order $order, array $data)
    {
        return $order->update($data);
    }

    public function processOrderDetails(Order $order, Collection $mealsData)
    {
        $total = 0;
        $mealIds = $mealsData->pluck('meal_id');
        $meals = Meal::whereIn('id', $mealIds)->get()->keyBy('id');

        foreach ($mealsData as $mealData) {
            $meal = $meals[$mealData['meal_id']];

            // Check availability
            if ($meal->quantity_available < $mealData['quantity']) {
                return 'Insufficient meal quantity available for meal: ' . $meal->description;
            }

            // Apply discount and calculate amount to pay
            $discountedPrice = $meal->price * (1 - ($meal->discount / 100));
            $amountToPay = $discountedPrice * $mealData['quantity'];

            // Create order detail
            OrderDetail::create([
                'order_id' => $order->id,
                'meal_id' => $meal->id,
                'amount_to_pay' => $amountToPay,
            ]);

            $total += $amountToPay;

            // Reduce meal quantity
            $meal->decrement('quantity_available', $mealData['quantity']);
        }

        // Return the total amount for the order
        return $total;
    }
}