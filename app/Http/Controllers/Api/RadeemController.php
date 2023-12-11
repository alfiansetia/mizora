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
            return $this->handle_unauth();
        }
        $headers = $this->set_headers(['Authorization' => $frontendToken]);
        try {
            $response = Http::withHeaders($headers)->get($this->base_url . '/api/radeem/all');
            return $this->handle_response($response);
        } catch (Exception $e) {
            return $this->handle_error($e->getMessage());
        }
    }

    public function show(Request $request, string $id = null)
    {
        $frontendToken = $request->header('Authorization');
        if (!$frontendToken) {
            return $this->handle_unauth();
        }
        if (!$id) {
            return $this->handle_not_found();
        }
        $headers = $this->set_headers(['Authorization' => $frontendToken]);
        try {
            $response = Http::asForm()->withHeaders($headers)->get($this->base_url . '/api/radeem/item_detail?radeem_id=' . $id);
            return $this->handle_response($response);
        } catch (Exception $e) {
            return $this->handle_error($e->getMessage());
        }
    }

    public function now(Request $request)
    {
        $frontendToken = $request->header('Authorization');
        if (!$frontendToken) {
            return $this->handle_unauth();
        }
        $this->validate($request, [
            'radeem_id' => 'required',
        ]);
        $param = [
            'radeem_id' => $request->radeem_id,
        ];
        $id = $request->radeem_id;
        $headers = $this->set_headers(['Authorization' => $frontendToken]);
        try {
            $response = Http::withHeaders($headers)->post($this->base_url . '/api/radeem/radeem_now', $param);
            return $this->handle_response($response);
        } catch (Exception $e) {
            return $this->handle_error($e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $frontendToken = $request->header('Authorization');
        if (!$frontendToken) {
            return $this->handle_unauth();
        }
        $this->validate($request, [
            'id_category_radeem'    => 'required',
            'title'                 => 'required',
            'goals'                 => 'required',
            'expired_at'            => 'required|date_format:Y-m-d H:i:s',
            'image'                 => 'required',
        ]);
        $param = [
            'radeem_id' => $request->radeem_id,
        ];
        $headers = $this->set_headers(['Authorization' => $frontendToken]);
        try {
            $response = Http::withHeaders($headers)->post($this->base_url . '/api/radeem/radeem_now', $param);
            return $this->handle_response($response);
        } catch (Exception $e) {
            return $this->handle_error($e->getMessage());
        }
    }

    public function items(Request $request)
    {
        $frontendToken = $request->header('Authorization');

        if (!$frontendToken) {
            return $this->handle_unauth();
        }
        $header = $this->headers;
        $header['Authorization'] = $frontendToken;
        $query = [];
        if ($request->filled('type')) {
            $query['type'] = $request->type;
        }
        if ($request->filled('category_id')) {
            $query['id'] = $request->category_id;
        }
        try {
            $response = Http::asForm()->withHeaders($header)->get($this->base_url . '/api/radeem/items', $query);
            $data = $response->json();
            if ($response->successful()) {
                $statusCode = $response->status();
                if ($response->status() === 201) {
                    $statusCode = 200;
                }
                if (empty($data['data'])) {
                    $data['data'] = [];
                }
                return response()->json($data, $statusCode);
            } else {
                if (isset($data['return']) || isset($data['status']) || isset($data['success']) || isset($data['message'])) {
                    return response()->json($data, $response->status());
                }
                return response()->json(['message' => 'Server Api Error!'], $response->status());
            }
        } catch (Exception $e) {
            return $this->handle_error($e->getMessage());
        }
    }
}
