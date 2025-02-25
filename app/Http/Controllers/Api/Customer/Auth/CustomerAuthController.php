<?php

namespace App\Http\Controllers\Api\Customer\Auth;

use App\Exceptions\CustomException;
use App\Http\Requests\Auth\LoginTokenRequest;
use App\Services\Auth\AuthService;
use App\Services\Log\LogService;
use App\Traits\ApiResponseHelper;

/**
 * @group Customer Authentication
 *
 * APIs for managing customer authentications like login, logout, check if user
 * exist and get logged in user details
 */
class CustomerAuthController
{
    use ApiResponseHelper;
    private $authService;
    private $logService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
        $this->logService = new LogService();
    }

    /**
     * Login
     *
     * @response {
     * "status": true,
     * "message": "Login Successfully",
     * "data": {
     * "id": 1,
     *"name": "Admin",
     *"username ": "Admin",
     * "email": "admin@example.com",
     * "phone": "+923001234567",
     * "image": null,
     * "emailVerifiedAt": null,
     * "token": "3|v1cIYL2YlidZKemvddM7C1xSeEqqaFRYDShPpcMA"
     * },
     * "links": [],
     * "meta": []
     * }
     */

    public function login(LoginTokenRequest $loginTokenRequest)
    {
        $this->logService->info('Customer login');
        try {
            return $this->authService->loginWithToken();
        } catch (CustomException $e) {
            $this->logService->error($e->getMessage());
            return $this->apiResponse(false, $e->getMessage(), $e->getMessage());
        } catch (\Exception $e) {
            $this->logService->error($e->getMessage());
            return $this->apiResponse(false, __('api.something_went_wrong'), $e->getMessage());
        }
    }

    public function logout()
    {
        $this->logService->info('Customer logout');
        try {
            return $this->authService->authLogout();
        } catch (CustomException $e) {
            $this->logService->error($e->getMessage());
            return $this->apiResponse(false, $e->getMessage(), $e->getMessage());
        } catch (\Exception $e) {
            $this->logService->error($e->getMessage());
            return $this->apiResponse(false, __('api.something_went_wrong'), $e->getMessage());
        }
    }
}
