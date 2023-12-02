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
            $response = Http::withHeaders($this->headers)->post($this->base_url . '/api/auth/send_otp', [
                'number' => $request->phone_number,
            ]);
            return $this->handle_response($response);
        } catch (Exception $e) {
            return $this->handle_error($e->getMessage());
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
            $response = Http::withHeaders($this->headers)->post($this->base_url . '/api/auth/verify_otp', [
                'number'    => $request->phone_number,
                'kode_otp'  => $request->otp,
            ]);
            return $this->handle_response($response);
        } catch (Exception $e) {
            return $this->handle_error($e->getMessage());
        }
    }

    public function get_profile(Request $request): JsonResponse
    {
        $frontendToken = $request->header('Authorization');
        if (!$frontendToken) {
            return $this->handle_unauth();
        }
        $headers = $this->set_headers(['Authorization' => $frontendToken]);
        try {
            $response = Http::withHeaders($headers)->get($this->base_url . '/api/profile/get_profile');
            return $this->handle_response($response);
        } catch (Exception $e) {
            return $this->handle_error($e->getMessage());
        }
    }

    public function update_profile(Request $request): JsonResponse
    {
        $frontendToken = $request->header('Authorization');

        if (!$frontendToken) {
            return $this->handle_unauth();
        }

        $this->validate($request, [
            // 'customer_name' => 'required',
            // 'cus_email'     => 'required|email',
            // 'tgl_lahir'     => 'required|date_format:Y-m-d',
            'cus_gender'    => 'required',
            'province_id'   => 'required',
            'kota_id'       => 'required',
            'cus_address'   => 'required',
            'postal_code'   => 'required',
            // 'cus_contact_2' => 'required',
        ]);
        try {
            $headers = $this->set_headers(['Authorization' => $frontendToken]);
            $response = Http::withHeaders($headers)->put($this->base_url . '/api/profile/user_profile', [
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
            return $this->handle_error($e->getMessage());
        }
    }

    public function logout(Request $request): JsonResponse
    {
        try {
            $frontendToken = $request->header('Authorization');

            if (!$frontendToken) {
                return $this->handle_unauth();
            }
            $headers = $this->set_headers(['Authorization' => $frontendToken]);
            $response = Http::withHeaders($headers)->post($this->base_url . '/api/auth/logout');
            return $this->handle_response($response);
        } catch (Exception $e) {
            return $this->handle_error($e->getMessage());
        }
    }
}
