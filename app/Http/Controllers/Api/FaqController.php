<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends BaseController
{
    public function index()
    {
        $data = Faq::all();
        return response()->json(['message' => '', 'data' => $data]);
    }
}
