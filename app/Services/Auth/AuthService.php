<?php

namespace App\Services\Auth;


use App\Exceptions\CustomException;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\Log\LogService;
use App\Traits\ApiResponseHelper;
use App\Traits\FirebaseHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthService
{
    use ApiResponseHelper, FirebaseHelper;
    private $request;
    private $logService;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->logService = new LogService();
    }

    //function for login with credentials i.e email, username, password etc
    public function loginWithCredentials()
    {
        $this->logService->info('Login with credentials');
        $user = User::where('email', $this->request->email)->first();
        if (!$user || !Hash::check($this->request->password, $user->password)) {
            throw new CustomException('The provided credentials are incorrect.');
        }

        if ($user->hasRole('admin')) {
            $token = $user->createToken($user->email)->plainTextToken;
            $tokenObj = ['token' => $token];
            $data = new UserResource($user);
            $data['data'] = collect($data)->merge($tokenObj);
            return $this->apiResponse(true, __('api.read'), $data);
        }
        throw new CustomException('User is not authorized');
    }

    //function for login with token with firebase token
    public function loginWithToken()
    {
        $this->logService->info('Login with token');
        $keys = $this->getFirebaseKeyIds();
        $decodedToken = JWT::decode($this->request->token, array_map(function ($key) {
            return new Key($key, 'RS256');
        }, $keys));

        if ($decodedToken->iss !== $this->getFirebaseIss()) {
            return $this->apiResponse(false, 'Invalid Token', [], 401);
        }
        $phone = $decodedToken->phone_number;
        if (empty($phone)) {
            return $this->apiResponse(false, 'Invalid mobile number in token', [], 401);
        }

        $user = User::where('phone', $phone)->first();
        //$user = User::where('phone', $this->request->phone)->first();

        if (!$user || !$user->hasRole('customer')) {
            throw  new CustomException('User not found');
        }

        $token = $user->createToken($user->email)->plainTextToken;
        $tokenObj = ['token' => $token];
        $data = new UserResource($user);
        $data['data'] = collect($data)->merge($tokenObj);
        return $this->apiResponse(true, __('api.read'), $data);
    }

    public function authLogout()
    {
        $this->logService->info('Logout');
        $user = Auth::user();
        $user->currentAccessToken()->delete();
        return $this->apiResponse(true, __('api.read'));
    }
}
