<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Message;
use Illuminate\Http\Request;
use Kutia\Larafirebase\Facades\Larafirebase;

class MessageController extends Controller
{

    public function __construct()
    {
        $this->middleware(['custom.auth'])->only(['push']);
    }

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

    public function push(Request $request, string $id)
    {
        $message = Message::Find($id);
        if (!$message) {
            return response()->json([
                'status'    => false,
                'message'   => 'Message Not Found!',
                'data'      => null
            ], 404);
        }
        $user_tokens = Customer::whereNotNull('fcm_token')->get()->pluck('fcm_token')->toArray();
        if (count($user_tokens) < 1) {
            return response()->json([
                'status'    => false,
                'message'   => 'There is no fcm token in the database!',
                'data'      => null
            ], 403);
        }
        $response = Larafirebase::withTitle($message->title)
            ->withBody($message->description)
            ->withImage($message->image)
            // ->withIcon('https://seeklogo.com/images/F/firebase-logo-402F407EE0-seeklogo.com.png')
            ->withSound('default')
            ->withClickAction($message->url_cta)
            ->withPriority('high')
            // ->withAdditionalData([
            //     'color' => '#rrggbb',
            //     'badge' => 0,
            // ])
            ->sendNotification($user_tokens);
        $json = json_decode($response, true);
        return response()->json([
            'status' => !empty($json),
            'message' => empty($json) ? 'Error Send Notification!' : 'Success Send Notification!',
            'data' => $json
        ], !empty($json) ? 200 : 500);
    }
}
