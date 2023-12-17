<?php

namespace App\Traits;

use Exception;

trait FirebaseTrait
{
    public function notification($title = null, array $fcm_tokens = [], $body = null, $cta = null)
    {
        try {

            $url = 'https://fcm.googleapis.com/fcm/send';

            $serverKey = env('FIREBASE_CREDENTIALS');

            $data = array(
                "registration_ids" => $fcm_tokens,
                'notification' => array(
                    "title" => $title,
                    "body" => $body,
                    "cta" => $cta,
                ),
                'content_available' => true,
                'priority' => "high",
                'click_action' => "FLUTTER_NOTIFICATION_FLUTTER",
            );

            $encodedData = json_encode($data);

            $headers = [
                'Authorization:key=' . $serverKey,
                'Content-Type: application/json',
            ];

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            // Disabling SSL Certificate support temporarly
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
            // Execute post

            $result = curl_exec($ch);
            if ($result === FALSE) {
                die('Curl failed: ' . curl_error($ch));
            }
            // Close connection
            curl_close($ch);
            return $result;
            // Log::debug("FCM Notification: " . $result);
            // FCM response
        } catch (Exception $e) {
            return $e->getMessage();
            // Log::error("FCM ERROR: " . $th);
        }
    }
}
