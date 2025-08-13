<?php


namespace App\Traits;

use App\Enums\System\ApiStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

trait ApiResponseTrait
{
    public function successResponse(int $code = 200, string $message = ('Success'), $data = null,)
    {
        return response()->json([
            'status' => ApiStatus::SUCCESS->value,
            'message' => $message,
            'code' => $code,
            'data' => $data,
        ], $code);
    }

    public function errorResponse(int $code = 500, string $message = __('Error')): JsonResponse
    {
        return response()->json([
            'status' => ApiStatus::ERROR->value,
            'code' => $code,
            'message' => $message,
        ], $code);
    }


    public function notFoundResponse(int $code = 404, string $message = __('Not Found'))
    {
        return response()->json([
            'status' => ApiStatus::NOT_FOUND->value,
            'message' => $message,
            'code' => $code,
        ], $code);
    }


    public function validationErrorResponse(int $code = 422, string $message = __("Validation Failed"), $errors): JsonResponse
    {
        return response()->json([
            'status' => ApiStatus::VALIDATION_FAILED->value,
            'message' => $message,
            'errors' => $errors,
            'code' => $code,
        ], $code);
    }


    public function unAuthorizedResponse(int $code = 403, string $message = __('Unauthorized')): JsonResponse
    {
        return response()->json([
            'status' => ApiStatus::UNAUTHORIZED->value,
            'message' => $message,
            'code' => $code,
        ], $code);
    }


    public  function logAndReturnErrorResponse(string $message)
    {
        Log::error(message: $message);
        return $this->errorResponse(message: $message);
    }
}
