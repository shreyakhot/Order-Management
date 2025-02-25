<?php

namespace App\Services\Firebase;

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class FirebaseService
{
    private $firebase_id;
    private $use_new_rtdb_uri;
    private $service_account_json;

    public function __construct()
    {
        $this->firebase_id = config('custom.firebase.firebase_id');
        $this->use_new_rtdb_uri = config('custom.firebase.use_new_rtdb_uri');
        $this->service_account_json = config('custom.firebase.service_account_json');
    }

    public function getDatabaseInstance()
    {
        $instance = null;
        try {
            $instance = (new Factory)->withServiceAccount(base_path() . '/' . $this->service_account_json);

            if ($this->use_new_rtdb_uri) {
                $instance = $instance->withDatabaseUri(\sprintf("https://%s-default-rtdb.firebaseio.com", $this->firebase_id));
            }
            $instance = $instance->createDatabase();
        } catch (\Exception $ex) {
            return $ex;
        }
        return $instance;
    }

    public function getFirebaseIss()
    {
        if ($this->firebase_id) {
            return "https://securetoken.google.com/" . $this->firebase_id;
        }
        return ''; // FIREBASE_ISS is for backward compatibility
    }
}
