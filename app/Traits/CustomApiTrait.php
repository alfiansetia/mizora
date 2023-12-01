<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait CustomApiTrait
{

    protected $base_url = 'apim.mizora.jewelry';

    protected $headers = [
        'Accept' => 'application/json',
    ];

    public function set_headers(array $new_header)
    {
        return $this->headers + $new_header;
    }

    public function handle_response($response)
    {
        $data = $response->json();
        if ($response->successful()) {
            $statusCode = 401;
            if (isset($data['return']) && $data['return']) {
                $statusCode = 200;
            } elseif (isset($data['status']) && $data['status']) {
                $statusCode = 200;
            } elseif (isset($data['success']) && $data['success']) {
                $statusCode = 200;
            }
            return response()->json($data, $statusCode);
        } else {
            if (isset($data['return']) || isset($data['status']) || isset($data['success'])) {
                return response()->json($data, $response->status());
            }
            return response()->json(['message' => 'Server Api Error!'], $response->status());
        }
    }

    public function handle_error(string $message)
    {
        response()->json(['message' => 'Terjadi kesalahan dalam pemanggilan API!' . $message], 500);
    }
}
