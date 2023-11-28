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
            $statusCode = 401; // Status default jika tidak ada yang terpenuhi

            if (isset($data['return']) && $data['return']) {
                $statusCode = 200;
            } elseif (isset($data['status']) && $data['status']) {
                $statusCode = 200;
            } elseif (isset($data['success']) && $data['success']) {
                $statusCode = 200;
            }
            return response()->json($data, $statusCode);
            // if (isset($data['return']) || isset($data['status']) || isset($data['success'])) {
            //     return response()->json($data, $data['return'] ?? $data['status'] ?? $data['success'] ? 200 : 401);
            // }
            // return response()->json($data, $response->status());
        } else {
            if (isset($data['return']) || isset($data['status']) || isset($data['success'])) {
                return response()->json($data, $response->status());
            }
            return response()->json(['message' => 'Server Api Error!'], $response->status());
        }
    }
}
