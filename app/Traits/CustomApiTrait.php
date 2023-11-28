<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait CustomApiTrait
{

    protected $base_url = 'apim.mizora.jewelry';

    public function handle_response($response)
    {
        $data = $response->json();
        if ($response->successful()) {
            if (isset($data['return']) || isset($data['status']) || isset($data['success'])) {
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
    }
}
