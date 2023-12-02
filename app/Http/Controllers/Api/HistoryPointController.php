<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\CustomApiTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HistoryPointController extends Controller
{
    use CustomApiTrait;

    public function index(Request $request)
    {
        $frontendToken = $request->header('Authorization');
        if (!$frontendToken) {
            return $this->handle_unauth();
        }
        $headers = $this->set_headers(['Authorization' => $frontendToken]);
        try {
            $response = Http::withHeaders($headers)->get($this->base_url . '/api/point/history?type=' . $request->type);
            return $this->handle_response($response);
        } catch (Exception $e) {
            return $this->handle_error($e->getMessage());
        }
    }
}
