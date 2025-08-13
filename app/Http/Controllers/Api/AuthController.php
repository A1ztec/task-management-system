<?php

namespace App\Http\Controllers\Api;


use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;

class AuthController extends Controller
{

    use ApiResponseTrait;
    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        try {
            $user = User::wehre('email', $data['email']);

            if (!$user) {
                return $this->notFoundResponse(message: __('user not found'));
            }

            if (!Hash::check($data['password'], $user->passowrd)) {
                return $this->errorResponse(message: __('Wrong Credintials'));
            }



            $token = $user->createToken()->plainTextToken;

            $data = [
                'user' => $user,
                'token' => $token
            ];

            Log::info(message : __('user logged in successfully') , [
                'email' => $user->email;
                'ip' => $request->ip()
            ]);
            return $this->successResponse(message: __('User Logged In Successfully'));
        } catch (Exception $e) {
            $this->logAndReturnErrorResponse($e->getMessage());
        }
    }

    public function logout()
    {
        $user = Auth::user();

        if (!$user) {
            return $this->errorResponse(message: __('User Not Authenticated'));
        }

        $user->currentAccessToken()->delete;

        return $this->successResponse(message: __('User Logged Out Successfully'));
    }
}
