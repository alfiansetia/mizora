<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CityController extends Controller
{
    public function index(Request $request)
    {
        $frontendToken = $request->header('Authorization');

        if (!$frontendToken) {
            return response()->json(['message' => 'Token from frontend is missing.'], 401);
        }
        try {
            $query = [];
            if ($request->filled('province_id')) {
                $query['province_id'] = $request->province_id;
            }
            $response = Http::withHeaders([
                'Authorization' => $frontendToken,
            ])->get('apiapp.mizora.jewelry/cities', $query);

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
