<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $data = Message::query();
        if ($request->filled('cat_name')) {
            $data->whereRelation('category', 'name', '=', $request->cat_name);
        }
        if ($request->filled('cat_id')) {
            $data->where('category_message_id', '=', $request->cat_id);
        }
        $result = $data->with('category')->orderBy('id', 'desc')->get();
        return response()->json(['message' => '', 'data' => $result]);
    }
}
