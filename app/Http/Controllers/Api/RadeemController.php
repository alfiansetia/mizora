<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\CustomApiTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RadeemController extends Controller
{
    use CustomApiTrait;

    public function index(Request $request)
    {
        $frontendToken = $request->header('Authorization');

        if (!$frontendToken) {
            return response()->json(['message' => 'Token from frontend is missing.'], 401);
        }
        $header = $this->headers;
        $header['Authorization'] = $frontendToken;
        $query = [];
        if ($request->filled('type')) {
            $query['type'] = $request->type;
        }
        if ($request->filled('id')) {
            $query['id'] = $request->id;
        }
        try {
            $response = Http::withHeaders($header)->get($this->base_url . '/api/radeem/all', $query);
            return $this->handle_response($response);
        } catch (Exception $e) {
            return $this->handle_error($e->getMessage());
        }
    }

    public function detail(Request $request)
    {
        $frontendToken = $request->header('Authorization');

        if (!$frontendToken) {
            return response()->json(['message' => 'Token from frontend is missing.'], 401);
        }
        $header = $this->headers;
        $header['Authorization'] = $frontendToken;
        $query = [];
        if ($request->filled('radeem_id')) {
            $query['radeem_id'] = $request->radeem_id;
        }
        try {
            $response = Http::asForm()->withHeaders($header)->get($this->base_url . '/api/radeem/item_detail', $query);
            return $this->handle_response($response);
        } catch (Exception $e) {
            return $this->handle_error($e->getMessage());
        }
    }

    public function items(Request $request)
    {
        $frontendToken = $request->header('Authorization');

        if (!$frontendToken) {
            return response()->json(['message' => 'Token from frontend is missing.'], 401);
        }
        $header = $this->headers;
        $header['Authorization'] = $frontendToken;
        $query = [];
        if ($request->filled('type')) {
            $query['type'] = $request->type;
        }
        if ($request->filled('id')) {
            $query['id'] = $request->id;
        }
        try {
            $response = Http::asForm()->withHeaders($header)->get($this->base_url . '/api/radeem/items', $query);
            return $this->handle_response($response);
        } catch (Exception $e) {
            return $this->handle_error($e->getMessage());
        }
    }
}
