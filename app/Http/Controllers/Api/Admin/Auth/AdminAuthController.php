<?php

namespace App\Http\Controllers\Api\Admin\Auth;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginCredentialsRequest;
use App\Services\Auth\AuthService;
use App\Services\Log\LogService;
use App\Traits\ApiResponseHelper;
use Illuminate\Http\Request;
use Psr\Cache\CacheException;

/**
 * @group Admin Authentication
 *
 * APIs for managing admin authentications like login, logout,
 */
class AdminAuthController extends Controller
{
    use ApiResponseHelper;

    private $authService;
    private $logService;

    public function __construct(Request $request)
    {
        $this->authService = new AuthService($request);
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

    public function login(LoginCredentialsRequest $request)
    {
        $this->logService->info('Admin login');
        try {
            return $this->authService->loginWithCredentials();
        } catch (CustomException $e) {
            $this->logService->error($e->getMessage());
            return $this->apiResponse(false, $e->getMessage(), $e->getMessage());
        } catch (\Exception $e) {
            $this->logService->error($e->getMessage());
            return $this->apiResponse(false, __('api.something_went_wrong'), $e->getMessage());
        }
    }

    /**
     * Logout
     *
     * @response {
     * "status" : true,
     * "message": "Logout successfully",
     * "data": [],
     * "links": [],
     * "meta": [],
     * }
     */

    public function logout()
    {
        $this->logService->info('Admin logout');
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
