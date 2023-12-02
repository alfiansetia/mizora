<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use App\Traits\CustomApiTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MembershipController extends Controller
{
    use CustomApiTrait;

    public function index(Request $request)
    {
        $frontendToken = $request->header('Authorization');
        if (!$frontendToken) {
            return $this->handle_unauth();
        }
        $headers = $this->set_headers(['Authorization' => $frontendToken]);
        $this->validate($request, [
            'membership_id' => 'required|in:1,2,3'
        ]);
        $id = $request->membership_id;
        try {
            $response = Http::withHeaders($headers)->get($this->base_url . '/api/membership/customer?membership_id=3');
            return $this->handle_response($response);
        } catch (Exception $e) {
            return $this->handle_error($e->getMessage());
        }
    }

    // public function index(Request $request)
    // {
    //     $data = Membership::query();
    //     $result = $data->get();
    //     return response()->json(['message' => '', 'data' => $result]);
    // }

    // public function get_me(Request $request)
    // {
    //     $frontendToken = $request->header('Authorization');

    //     if (!$frontendToken) {
    //         return response()->json(['message' => 'Token from frontend is missing.'], 401);
    //     }
    //     try {
    //         $response = Http::withHeaders([
    //             'Authorization' => $frontendToken,
    //         ])->get('apiapp.mizora.jewelry/user_profile');

    //         // $statusCode = $response->status();
    //         $data = $response->json();
    //         if ($response->successful()) {
    //             if (isset($data['return'])) {
    //                 return response()->json($data, $data['return'] ? 200 : 401);
    //             }
    //             return response()->json($data, $response->status());
    //         } else {
    //             if (isset($data['return'])) {
    //                 return response()->json($data, $response->status());
    //             }
    //             return response()->json(['message' => 'Server Api Error!'], $response->status());
    //         }
    //     } catch (Exception $e) {
    //         return response()->json(['message' => 'Terjadi kesalahan dalam pemanggilan API.'], 500);
    //     }
    // }
}
