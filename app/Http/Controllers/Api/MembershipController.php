<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MembershipController extends Controller
{
    public function index(Request $request)
    {
        $data = Membership::query();
        $result = $data->get();
        return response()->json(['message' => '', 'data' => $result]);
    }

    public function get_me(Request $request)
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
}
