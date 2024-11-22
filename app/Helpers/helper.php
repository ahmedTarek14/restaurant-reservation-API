<?php
use Modules\Vote\Entities\Vote;

if (!function_exists('failed_validation')) {
    function failed_validation($error)
    {
        return response()->json($error, 400);
    }
}

if (!function_exists('add_response')) {
    function add_response()
    {
        return response()->json('Data has been added successfully', 200);
    }
}

if (!function_exists('update_response')) {
    function update_response()
    {
        return response()->json('Data has been updated successfully', 200);
    }
}

if (!function_exists('error_response')) {
    function error_response()
    {
        return response()->json('Error , please try again later', 400);
    }
}

if (!function_exists('success_response')) {
    function success_response($message)
    {
        return response()->json($message, 200);
    }
}

if (!function_exists('api_response_success')) {
    function api_response_success($data)
    {
        return response()->json([
            'status' => true,
            'data' => $data,
        ], 200);
    }
}

if (!function_exists('api_response_error')) {
    function api_response_error($message = null)
    {
        $message = $message != null ? $message : 'Error , please try again later';

        return response()->json([
            'status' => false,
            'message' => $message,
        ], 400);
    }
}
