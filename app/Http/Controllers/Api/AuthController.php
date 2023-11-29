<?php

namespace App\Http\Controllers\Api;

use App\Traits\CustomApiTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends BaseController
{
    use CustomApiTrait;

    public function login(Request $request): JsonResponse
    {
        $this->validate(
            $request,
            [
                'phone_number' => 'required'
            ]
        );
        try {
            $response = Http::post($this->base_url . '/api/auth/send_otp', [
                'number' => $request->phone_number,
            ]);
            return $this->handle_response($response);
        } catch (Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan dalam pemanggilan API! ' . $e->getMessage()], 500);
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
            $response = Http::post($this->base_url . '/api/auth/verify_otp', [
                'number'    => $request->phone_number,
                'kode_otp'  => $request->otp,
            ]);
            return $this->handle_response($response);
        } catch (Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan dalam pemanggilan API! ' . $e->getMessage()], 500);
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
            ])->get($this->base_url . '/api/profile/get_profile');
            return $this->handle_response($response);
        } catch (Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan dalam pemanggilan API! ' . $e->getMessage()], 500);
        }
    }

    public function update_profile(Request $request): JsonResponse
    {
        $frontendToken = $request->header('Authorization');

        if (!$frontendToken) {
            return response()->json(['message' => 'Token from frontend is missing.'], 401);
        }

        $this->validate($request, [
            // 'customer_name' => 'required',
            // 'cus_email'     => 'required|email',
            // 'tgl_lahir'     => 'required|date_format:Y-m-d',
            'cus_gender'    => 'required|in:1,2',
            'province_id'   => 'required|integer',
            'kota_id'       => 'required|integer',
            'cus_address'   => 'required',
            'postal_code'   => 'required',
            // 'cus_contact_2' => 'required',
        ]);
        try {
            $response = Http::withHeaders([
                'Authorization' => $frontendToken,
            ])->put($this->base_url . '/api/profile/user_profile', [
                // 'customer_name' => $request->customer_name,
                // 'cus_email'     => $request->cus_email,
                // 'tgl_lahir'     => $request->tgl_lahir,
                'cus_gender'    => $request->cus_gender,
                'province_id'   => $request->province_id,
                'kota_id'       => $request->kota_id,
                'cus_address'   => $request->cus_address,
                'postal_code'   => $request->postal_code,
                // 'cus_contact_2' => $request->cus_contact_2,
            ]);
            return $this->handle_response($response);
        } catch (Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan dalam pemanggilan API! ' . $e->getMessage()], 500);
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
            ])->post($this->base_url . '/api/auth/logout');
            return $this->handle_response($response);
        } catch (Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan dalam pemanggilan API! ' . $e->getMessage()], 500);
        }
    }
}
