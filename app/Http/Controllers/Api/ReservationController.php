<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ReservationAvailabilityRequest;
use App\Http\Requests\Api\ReservationRequest;
use App\Http\Resources\TableResource;
use App\Models\Reservation;
use App\Models\WaitingList;
use App\Repositories\ReservationRepository;
use Carbon\Carbon;


class ReservationController extends Controller
{
    protected $reservationRepository;

    public function __construct(ReservationRepository $reservationRepository)
    {
        $this->reservationRepository = $reservationRepository;
    }

    public function checkAvailability(ReservationAvailabilityRequest $request)
    {
        $requestedStartTime = Carbon::parse($request->from_time);
        $requestedEndTime = Carbon::parse($request->to_time);

        $availableTable = $this->reservationRepository->findAvailableTable(
            $request->number_of_guests,
            $requestedStartTime,
            $requestedEndTime
        );

        return $availableTable
            ? api_response_success('Table is available!')
            : api_response_error("Table isn't available");
    }

    public function reserveTable(ReservationRequest $request)
    {
        $requestedStartTime = Carbon::parse($request->from_time);
        $requestedEndTime = Carbon::parse($request->to_time);
        $requestedDate = $requestedStartTime->toDateString();

        // Check if the customer already has a reservation on the same day
        $existingReservation = Reservation::where('customer_id', $request->customer_id)->whereDate('from_time', $requestedDate)->first();

        $existingWaitingList = WaitingList::where('customer_id', $request->customer_id)->whereDate('added_at', $requestedDate)->first();

        if ($existingReservation) {
            return api_response_error('You already have a reservation on this day.');
        }

        // Find an available table for the requested time and guest capacity
        $availableTable = $this->reservationRepository->findAvailableTable(
            $request->number_of_guests,
            $requestedStartTime,
            $requestedEndTime
        );

        if (!$availableTable) {
            //check if customer in waiting list or not
            if (!$existingWaitingList) {
                WaitingList::create([
                    'customer_id' => $request->customer_id,
                    'added_at' => now(),
                ]);
            }

            return api_response_error('No available table for the requested number of guests during the selected time. You have been added to the waiting list.');
        }

        // Reserve the table
        Reservation::create([
            'customer_id' => $request->customer_id,
            'table_id' => $availableTable->id,
            'from_time' => $request->from_time,
            'to_time' => $request->to_time,
        ]);

        // Remove customer from the waiting list if they are on it in the same day after reserving
        if ($existingWaitingList) {
            $existingWaitingList->delete();
        }

        return response()->json([
            'message' => 'Table successfully reserved!',
            'table' => new TableResource($availableTable),
        ]);
    }
}