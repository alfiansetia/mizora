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
    private $base_url = 'apim.mizora.jewelry';

    public function login(Request $request): JsonResponse
    {

        $this->validate(
            $request,
            [
                'phone_number' => 'required'
            ]
        );
        try {
            $response = Http::asForm()->post($this->base_url . '/api/auth/send_otp', [
                'number' => $request->phone_number,
            ]);
            $data = $response->json();
            if ($response->successful()) {
                if (isset($data['return']) || isset($data['status'])) {
                    return response()->json($data, $data['return'] ? 200 : 401);
                }
                return response()->json($data, $response->status());
            } else {
                return response()->json($data, $response->status());
                if (isset($data['return']) || isset($data['status'])) {
                    return response()->json($data, $response->status());
                }
                return response()->json(['message' => 'Server Api Error!'], $response->status());
            }
        } catch (Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan dalam pemanggilan API.' . $e->getMessage()], 500);
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
            $response = Http::asForm()->post($this->base_url . '/api/auth/verify_otp', [
                'kode_otp'  => $request->otp,
                'number'    => $request->phone_number,
            ]);
            $data = $response->json();
            if ($response->successful()) {
                if (isset($data['return']) || isset($data['status'])) {
                    return response()->json($data, $data['return'] ? 200 : 401);
                }
                return response()->json($data, $response->status());
            } else {
                return response()->json($data, $response->status());
                if (isset($data['return']) || isset($data['status']) || isset($data['success'])) {
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
            $response = Http::asForm()->withHeaders([
                'Authorization' => $frontendToken,
            ])->get($this->base_url . '/api/profile/get_profile');
            $data = $response->json();
            if ($response->successful()) {
                if (isset($data['return']) || isset($data['status'])) {
                    return response()->json($data, $data['return'] ? 200 : 401);
                }
                return response()->json($data, $response->status());
            } else {
                if (isset($data['return']) || isset($data['status'])) {
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
            'cus_name'      => 'required',
            // 'cus_gender'    => 'required',
            'province_id'   => 'required|integer',
            'kota_id'       => 'required|integer',
            'cus_address'   => 'required',
            'postal_code'   => 'required',
            'contact_1'     => 'required',
        ]);
        try {
            $response = Http::asForm()->withHeaders([
                'Authorization' => $frontendToken,
            ])->post($this->base_url . '/api/profile/user_profile', [
                'cus_name'      => $request->cus_name,
                // 'cus_gender'    => $request->cus_gender,
                'province_id'   => $request->province_id,
                'kota_id'       => $request->kota_id,
                'cus_address'   => $request->cus_address,
                'postal_code'   => $request->postal_code,
                'cus_contact_1' => $request->contact_1,
            ]);

            $data = $response->json();
            if ($response->successful()) {
                if (isset($data['return']) || isset($data['status'])) {
                    return response()->json($data, $data['return'] ? 200 : 401);
                }
                return response()->json($data, $response->status());
            } else {
                if (isset($data['return']) || isset($data['status'])) {
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
            $response = Http::asForm()->withHeaders([
                'Authorization' => $frontendToken,
            ])->post($this->base_url . '/api/auth/logout');

            $data = $response->json();

            if ($response->successful()) {
                if (isset($data['return']) || isset($data['status'])) {
                    return response()->json($data, $data['return'] ? 200 : 401);
                }
                return response()->json($data, $response->status());
            } else {
                if (isset($data['return']) || isset($data['status'])) {
                    return response()->json($data, $response->status());
                }
                return response()->json(['message' => 'Server Api Error! '], $response->status());
            }
        } catch (Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan dalam pemanggilan API.'], 500);
        }
    }
}
