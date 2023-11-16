<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\AuthRequest;
use App\Http\Requests\PasswordChangeRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class AuthController extends BaseController
{
    public function login(Request $request): JsonResponse
    {
        $this->validate(
            $request,
            [
                'phone_number' => 'required'
            ]
        );
        try {
            $response = Http::post('apiapp.mizora.jewelry/auth', [
                'phone_number' => $request->phone_number,
            ]);

            $data = $response->json();
            if ($response->successful()) {
                if (isset($data['return'])) {
                    return response()->json($data, $data['return'] ? 200 : 401);
                }
                return response()->json($data, $response->status());
            } else {
                if (isset($data['return'])) {
                    return response()->json($data, $response->status());
                }
                return response()->json(['message' => 'Server Api Error!'], $response->status());
            }
        } catch (Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan dalam pemanggilan API.'], 500);
        }
    }

    public function verify_otp(Request $request): JsonResponse
    {
        $this->validate(
            $request,
            [
                'otp' => 'required',
                'phone_number' => 'required',
            ]
        );
        try {
            $response = Http::post('apiapp.mizora.jewelry/verify_otp', [
                'otp'           => $request->otp,
                'phone_number'  => $request->phone_number,
            ]);

            // $statusCode = $response->status();
            $data = $response->json();
            if ($response->successful()) {
                if (isset($data['return'])) {
                    return response()->json($data, $data['return'] ? 200 : 401);
                }
                return response()->json($data, $response->status());
            } else {
                if (isset($data['return'])) {
                    return response()->json($data, $response->status());
                }
                return response()->json(['message' => 'Server Api Error!'], $response->status());
            }
        } catch (Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan dalam pemanggilan API.'], 500);
        }
    }

    public function get_profile(Request $request): JsonResponse
    {
        $frontendToken = $request->header('Authorization');

        if (!$frontendToken) {
            return response()->json(['message' => 'Token from frontend is missing.'], 401);
        }
        try {
            $response = Http::withHeaders([
                'Authorization' => $frontendToken,
            ])->get('apiapp.mizora.jewelry/user_profile');

            // $statusCode = $response->status();
            $data = $response->json();
            if ($response->successful()) {
                if (isset($data['return'])) {
                    return response()->json($data, $data['return'] ? 200 : 401);
                }
                return response()->json($data, $response->status());
            } else {
                if (isset($data['return'])) {
                    return response()->json($data, $response->status());
                }
                return response()->json(['message' => 'Server Api Error!'], $response->status());
            }
        } catch (Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan dalam pemanggilan API.'], 500);
        }
    }

    public function update_profile(Request $request): JsonResponse
    {
        $frontendToken = $request->header('Authorization');

        if (!$frontendToken) {
            return response()->json(['message' => 'Token from frontend is missing.'], 401);
        }

        $this->validate($request, [
            'cus_gender'    => 'required',
            'province_id'   => 'required|integer',
            'kota_id'       => 'required|integer',
            'cus_address'   => 'required',
            'postal_code'   => 'required',
        ]);
        try {
            $response = Http::withHeaders([
                'Authorization' => $frontendToken,
            ])->put('apiapp.mizora.jewelry/user_profile', [
                'cus_gender'    => $request->cus_gender,
                'province_id'   => $request->province_id,
                'kota_id'       => $request->kota_id,
                'cus_address'   => $request->cus_address,
                'postal_code'   => $request->postal_code,
            ]);

            // $statusCode = $response->status();
            $data = $response->json();
            if ($response->successful()) {
                if (isset($data['return'])) {
                    return response()->json($data, $data['return'] ? 200 : 401);
                }
                return response()->json($data, $response->status());
            } else {
                if (isset($data['return'])) {
                    return response()->json($data, $response->status());
                }
                return response()->json(['message' => 'Server Api Error!'], $response->status());
            }
        } catch (Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan dalam pemanggilan API.'], 500);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        try {
            $frontendToken = $request->header('Authorization');

            if (!$frontendToken) {
                return response()->json(['message' => 'Token from frontend is missing.'], 401);
            }
            $response = Http::withHeaders([
                'Authorization' => $frontendToken,
            ])->post('apiapp.mizora.jewelry/logout');

            $data = $response->json();

            if ($response->successful()) {
                if (isset($data['return'])) {
                    return response()->json($data, $data['return'] ? 200 : 401);
                }
                return response()->json($data, $response->status());
            } else {
                if (isset($data['return'])) {
                    return response()->json($data, $response->status());
                }
                return response()->json(['message' => 'Server Api Error! '], $response->status());
            }
        } catch (Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan dalam pemanggilan API.'], 500);
        }
    }
}
