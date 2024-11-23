<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\OrderRequest;
use App\Http\Resources\InvoiceResource;
use App\Models\Meal;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Repositories\OrderRepository;
use App\Repositories\ReservationRepository;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }
    public function placeOrder(OrderRequest $request)
    {
        try {
            // Check if an order already exists for the given reservation
            $existingOrder = Order::where('reservation_id', $request->reservation_id)->first();
            if ($existingOrder) {
                return api_response_error('An order already exists for this reservation.');
            }
            $order = $this->orderRepository->create([
                'customer_id' => $request->customer_id,
                'reservation_id' => $request->reservation_id,
                'total' => 0,
                'paid' => false,
                'date' => now(),
            ]);

            $total = $this->orderRepository->processOrderDetails($order, collect($request->meals));

            if (is_string($total)) {
                return api_response_error($total);
            }

            $this->orderRepository->update($order, ['total' => $total]);

            return api_response_success([
                'order_id' => $order->id,
                'total' => $total,
            ]);
        } catch (\Throwable $th) {
            return api_response_error();
        }
    }

    public function checkout(Request $request)
    {
        try {
            $validated = $request->validate([
                'order_id' => 'required|exists:orders,id',
            ]);

            $order = Order::findOrFail($validated['order_id']);
            $order->update(['paid' => true]);

            $data = new InvoiceResource($order);

            return api_response_success($data);
        } catch (\Throwable $th) {
            return api_response_error();
        }
    }
}