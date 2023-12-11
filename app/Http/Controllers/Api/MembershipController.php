<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use App\Traits\CustomApiTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MembershipController extends Controller
{
    use CustomApiTrait;

    // public function index(Request $request)
    // {
    //     $frontendToken = $request->header('Authorization');
    //     if (!$frontendToken) {
    //         return $this->handle_unauth();
    //     }
    //     $headers = $this->set_headers(['Authorization' => $frontendToken]);
    //     $this->validate($request, [
    //         'membership_id' => 'required|in:1,2,3'
    //     ]);
    //     $id = $request->membership_id;
    //     try {
    //         $response = Http::withHeaders($headers)->get($this->base_url . '/api/membership/customer?membership_id=3');
    //         return $this->handle_response($response);
    //     } catch (Exception $e) {
    //         return $this->handle_error($e->getMessage());
    //     }
    // }

    public function index(Request $request)
    {
        $data = Membership::query();
        $result = $data->get();
        return response()->json(['message' => '', 'data' => $result]);
    }

    public function show(string $id)
    {
        $data = Membership::find($id);
        if (!$data) {
            return $this->handle_not_found();
        }
        return response()->json(['message' => '', 'data' => $data]);
    }

    // public function current(Request $request)
    // {
    //     $frontendToken = $request->header('Authorization');

    //     if (!$frontendToken) {
    //         return $this->handle_unauth();
    //     }
    //     try {
    //         $response = Http::withHeaders([
    //             'Authorization' => $frontendToken,
    //         ])->get($this->base_url . '/api/profile/get_profile');

    //         // $statusCode = $response->status();
    //         $data = $response->json();
    //         if ($response->successful()) {
    //             if (empty($data)) {
    //                 return $this->handle_not_found();
    //             }
    //             $memberships = Membership::orderBy('transaction_from', 'DESC')->get();
    //             $current_membership = null;
    //             $next_membership = null;
    //             $current_point = 0;
    //             $point_to_next_membership = 0;
    //             if (isset($data['data']) && isset($data['data']['cus_point_membership'])) {
    //                 $current_point = intval($data['data']['cus_point_membership']);
    //             }

    //             foreach ($memberships as $membership) {
    //                 if ($current_point >= $membership->transaction_from && $current_point <= $membership->transaction_to) {
    //                     $current_membership = $membership;
    //                     break;
    //                 }
    //             }
    //             foreach ($memberships as $membership) {
    //                 if ($current_membership && $membership->transaction_from > $current_membership->transaction_to) {
    //                     $next_membership = $membership;
    //                     break;
    //                 }
    //             }

    //             if ($next_membership) {
    //                 $point_to_next_membership = $next_membership->transaction_from - $current_point;
    //             }

    //             return response()->json([
    //                 'message' => '',
    //                 'data' => [
    //                     'current_point_membership'  => $current_point,
    //                     'point_to_next_membership'  => $point_to_next_membership,
    //                     'current_membership'        => $current_membership,
    //                     'next_membership'           => $next_membership,
    //                 ]
    //             ]);
    //         } else {
    //             if (isset($data['return']) || isset($data['status']) || isset($data['success']) || isset($data['message'])) {
    //                 return response()->json($data, $response->status());
    //             }
    //             return response()->json(['message' => 'Server Api Error!'], $response->status());
    //         }
    //     } catch (Exception $e) {
    //         return $this->handle_error($e->getMessage());
    //     }
    // }
}
