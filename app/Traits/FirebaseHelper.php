<?php

namespace App\Traits;

trait FirebaseHelper
{
    /*
     * @param array|string $data
     * @param string $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */

    protected function getFirebaseKeyIds()
    {
        $publicKeyURL = 'https://www.googleapis.com/robot/v1/metadata/x509/securetoken@system.gserviceaccount.com';
        if (!ini_get('allow_url_fopen')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $publicKeyURL);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $publicKey = curl_exec($ch);
            curl_close($ch);
            $kIds = json_decode($publicKey, true);
        } else {
            $kIds = json_decode(file_get_contents($publicKeyURL), true);
        }

        //$firstKey = key($kIds); // returns the first key of the array (i.e., 'key1')
        //return $firstValue = reset($kIds); // returns the first value of the array (i.e., 'value1')
        return $kIds; //PUBLIC KEY
    }

    protected function getFirebaseIss()
    {
        $firebase_id = config('custom.firebase_id');
        if ($firebase_id) {
            return "https://securetoken.google.com/" . $firebase_id;
        }
    }
}
