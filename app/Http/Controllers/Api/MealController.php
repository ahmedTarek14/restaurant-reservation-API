<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MealResource;
use App\Models\Meal;
use Illuminate\Http\Request;

class MealController extends Controller
{
    public function listMenu()
    {
        try {
            $meals = Meal::select('id', 'description', 'price', 'quantity_available', 'discount')->paginate(10);

            $data = MealResource::collection($meals)->response()->getData(true);

            return api_response_success($data);
        } catch (\Throwable $th) {
            return api_response_error();
        }
    }
}