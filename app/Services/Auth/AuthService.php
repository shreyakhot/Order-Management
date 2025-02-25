<?php

namespace App\Services\Auth;


use App\Exceptions\CustomException;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\Log\LogService;
use App\Traits\ApiResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    use ApiResponseHelper;
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


    public function authLogout()
    {
        $this->logService->info('Logout');
        $user = Auth::user();
        $user->currentAccessToken()->delete();
        return $this->apiResponse(true, __('api.read'));
    }
}
