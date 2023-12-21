<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CategoryMessage;
use App\Models\Customer;
use App\Models\Message;
use App\Models\MessageUser;
use App\Traits\CustomApiTrait;
use App\Traits\FirebaseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Kutia\Larafirebase\Facades\Larafirebase;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    use CustomApiTrait;
    use FirebaseTrait;


    public function __construct()
    {
        $this->middleware(['custom.auth'])->only(['index', 'user']);
    }
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category'      => 'required|exists:category_message,name',
            'title'         => 'required|max:200',
            'url_cta'       => 'required|max:200',
            'label_cta'     => 'required|max:200',
            'description'   => 'required|max:200',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'    => false,
                'message'   => 'Form not Complete!',
                'errors'    => $validator->errors(),
                'data'      => null,
            ], 422);
        }
        $category = CategoryMessage::where('name', $request->category)->first();
        $message = Message::create([
            'category_message_id'   => $category->id,
            'title'                 => $request->title,
            'url_cta'               => $request->url_cta,
            'label_cta'             => $request->label_cta,
            'description'           => $request->description,
            'datetime'              => now(),
        ]);
        $user_tokens = Customer::whereNotNull('fcm_token')->get()->pluck('fcm_token')->toArray();
        if (count($user_tokens) < 1) {
            return response()->json([
                'status'    => false,
                'message'   => 'There is no fcm token in the database!',
                'data'      => null
            ], 403);
        }
        $response = Larafirebase::withTitle($request->title)
            ->withBody($request->description)
            // ->withImage('https://firebase.google.com/images/social.png')
            // ->withIcon('https://seeklogo.com/images/F/firebase-logo-402F407EE0-seeklogo.com.png')
            ->withSound('default')
            ->withClickAction($request->url_cta)
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

    public function user(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'         => 'required|max:200',
            'url_cta'       => 'required|max:200',
            'label_cta'     => 'required|max:200',
            'description'   => 'required|max:200',
            'user_id'       => [
                'required',
                function ($attribute, $value, $fail) {
                    $customer = Customer::find($value);
                    if (!$customer) {
                        $fail('User Not found!');
                    }
                    if ($customer && !$customer->fcm_token) {
                        $fail('The selected user does not have a valid fcm_token!');
                    }
                }
            ]
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'    => false,
                'message'   => 'Form not Complete!',
                'errors'    => $validator->errors(),
                'data'      => null,
            ], 422);
        }
        $message = MessageUser::create([
            'customer_id'           => $request->user_id,
            'title'                 => $request->title,
            'url_cta'               => $request->url_cta,
            'label_cta'             => $request->label_cta,
            'description'           => $request->description,
            'datetime'              => now(),
        ]);
        $token_user[] = Customer::find($request->user_id)->fcm_token;
        $response = Larafirebase::withTitle($request->title)
            ->withBody($request->body)
            ->withSound('default')
            ->withClickAction($request->url_cta)
            ->withPriority('high')
            ->sendNotification($token_user);
        $json = json_decode($response, true);
        return response()->json([
            'status' => !empty($json),
            'message' => empty($json) ? 'Error Send Notification!' : '',
            'data' => $json
        ], !empty($json) ? 200 : 500);
    }

    public function saveToken(Request $request)
    {
        $this->validate($request, [
            'fcm_token' => 'required',
        ]);

        $frontendToken = $request->header('Authorization');
        if (!$frontendToken) {
            return $this->handle_unauth();
        }

        $headers = $this->set_headers(['Authorization' => $frontendToken]);
        try {
            $response = Http::withHeaders($headers)->get($this->base_url . '/api/profile/get_profile');
            $data = $response->json();
            if ($response->successful()) {
                if (empty($data)) {
                    return $this->handle_not_found();
                }
                if (isset($data['data']) && isset($data['data']['id'])) {
                    $id = $data['data']['id'];
                    Customer::updateOrCreate([
                        'id'            => $id,
                    ], [
                        'id'            => $id,
                        'customer_name' => $data['data']['customer_name'] ?? '',
                        'cus_contact_2' => $data['data']['cus_contact_2'] ?? '',
                        'cus_email'     => $data['data']['cus_email'] ?? '',
                        'token'         => $frontendToken,
                        'fcm_token'     => $request->fcm_token,
                    ]);
                    return response()->json(['message' => 'Save token success'], 200);
                }
                return response()->json(['message' => 'Failed save token!'], 500);
            } else {
                return response()->json(['message' => 'Failed save token!'], 401);
            }
        } catch (Exception $e) {
            return $this->handle_error($e->getMessage());
        }
    }
}
