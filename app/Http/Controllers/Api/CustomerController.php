<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Traits\CustomApiTrait;
use App\Traits\FirebaseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Kutia\Larafirebase\Facades\Larafirebase;

class CustomerController extends Controller
{
    use CustomApiTrait;
    use FirebaseTrait;


    public function __construct()
    {
    }
    public function index(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body'  => 'required',
        ]);
        $user_tokens = Customer::whereNotNull('fcm_token')->get()->pluck('fcm_token')->toArray();
        if (count($user_tokens) < 1) {
            return response()->json([
                'status' => false,
                'message' => 'There is no fcm token in the database!',
                'data' => null
            ]);
        }
        $response = Larafirebase::withTitle($request->title)
            ->withBody($request->body)
            // ->withImage('https://firebase.google.com/images/social.png')
            // ->withIcon('https://seeklogo.com/images/F/firebase-logo-402F407EE0-seeklogo.com.png')
            ->withSound('default')
            // ->withClickAction('https://www.google.com')
            ->withPriority('high')
            // ->withAdditionalData([
            //     'color' => '#rrggbb',
            //     'badge' => 0,
            // ])
            ->sendNotification($user_tokens);
        $json = json_decode($response, true);
        return response()->json([
            'status' => !empty($json),
            'message' => empty($json) ? 'Error Send Notification!' : '',
            'data' => $json
        ], !empty($json) ? 200 : 500);
    }

    public function user(Request $request)
    {
        $this->validate($request, [
            'title'     => 'required',
            'body'      => 'required',
            'user_id'   => [
                'required',
                function ($attribute, $value, $fail) {
                    $customer = Customer::find($value);
                    if (!$customer) {
                        $fail('User Not found!');
                    }
                    if ($customer  && !$customer->fcm_token) {
                        $fail('The selected user does not have a valid fcm_token!');
                    }
                }
            ]
        ]);
        $token_user[] = Customer::find($request->user_id)->fcm_token;
        $response = Larafirebase::withTitle($request->title)
            ->withBody($request->body)
            ->withSound('default')
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
