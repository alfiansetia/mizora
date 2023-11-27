<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProvinceController extends Controller
{
    private $base_url = 'apim.mizora.jewelry';

    public function index(Request $request)
    {
        $frontendToken = $request->header('Authorization');

        if (!$frontendToken) {
            return response()->json(['message' => 'Token from frontend is missing.'], 401);
        }
        try {
            $response = Http::asForm()->withHeaders([
                'Authorization' => $frontendToken,
            ])->get($this->base_url . '/api/address/provinces');
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
}
