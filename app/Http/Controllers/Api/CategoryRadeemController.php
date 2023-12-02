<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\CustomApiTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CategoryRadeemController extends Controller
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
            $response = Http::withHeaders($headers)->get($this->base_url . '/api/radeem/category');
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
            $response = Http::asForm()->withHeaders($headers)->get($this->base_url . '/api/radeem/category_id?id=' . $id);
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
            'title'     => 'required',
            'status'    => 'required',
            'icon'      => 'required',
        ]);
        $param = [
            'title'     => $request->title,
            'status'    => $request->status,
            'icon'      => $request->icon,
        ];
        $headers = $this->set_headers(['Authorization' => $frontendToken]);
        try {
            $response = Http::asForm()->withHeaders($headers)->post($this->base_url . '/api/radeem/category_insert', $param);
            return $this->handle_response($response);
        } catch (Exception $e) {
            return $this->handle_error($e->getMessage());
        }
    }

    public function update(Request $request,  string $id)
    {
        $frontendToken = $request->header('Authorization');
        if (!$frontendToken) {
            return $this->handle_unauth();
        }
        if (!$id) {
            return $this->handle_not_found();
        }
        $this->validate($request, [
            'title'     => 'required',
            'status'    => 'required',
            'icon'      => 'required',
        ]);
        $param = [
            'id'        => $id,
            'title'     => $request->title,
            'status'    => $request->status,
            'icon'      => $request->icon,
        ];
        $headers = $this->set_headers(['Authorization' => $frontendToken]);
        try {
            $response = Http::asForm()->withHeaders($headers)->put($this->base_url . '/api/radeem/category_upd', $param);
            return $this->handle_response($response);
        } catch (Exception $e) {
            return $this->handle_error($e->getMessage());
        }
    }

    public function destroy(Request $request,  string $id)
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
            $response = Http::asForm()->withHeaders($headers)->put($this->base_url . '/api/radeem/category_upd?id=' . $id);
            return $this->handle_response($response);
        } catch (Exception $e) {
            return $this->handle_error($e->getMessage());
        }
    }
}
