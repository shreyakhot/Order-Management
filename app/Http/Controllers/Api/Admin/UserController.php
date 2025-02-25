<?php

namespace App\Http\Controllers\Api\Admin;

use App\Exceptions\CustomException;
use App\Http\Requests\Admin\UserRequest;
use App\Services\Log\LogService;
use App\Services\User\UserService;
use App\Http\Controllers\Controller;
use App\Http\Filters\UserFilter;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\ApiResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

/**
 * @group Admin Users
 *
 * APIs for managing users admin side
 */
class UserController extends Controller
{
    use ApiResponseHelper;
    private $userService;
    private $logService;

    public function __construct()
    {
        $this->userService = new UserService();
        $this->logService = new LogService();
    }

    public function index(Request $request)
    {
        $this->logService->info('Admin users');
        try {
            $data = $this->userService->index($request);
            return $this->apiResponse(true, __('api.read'), $data);
        } catch (CustomException $e) {
            $this->logService->error($e->getMessage());
            return $this->apiResponse(false, $e->getMessage(), $e->getMessage());
        } catch (\Exception $e) {
            $this->logService->error($e->getMessage());
            return $this->apiResponse(false, __('api.something_went_wrong'), $e->getMessage());
        }
    }

    public function store(UserRequest $request)
    {
        $this->logService->info('Admin users store');
        try {
            $data = $this->userService->create($request);
            return $this->apiResponse(true, __('api.read'), $data);
        } catch (CustomException $e) {
            $this->logService->error($e->getMessage());
            return $this->apiResponse(false, $e->getMessage(), $e->getMessage());
        } catch (\Exception $e) {
            $this->logService->error($e->getMessage());
            return $this->apiResponse(false, __('api.something_went_wrong'), $e->getMessage());
        }

    }

    public function show($id)
    {
        $this->logService->info('Admin users show');
        try {
            $data = $this->userService->show($id);
            return $this->apiResponse(true, __('api.read'), $data);
        } catch (CustomException $e) {
            $this->logService->error($e->getMessage());
            return $this->apiResponse(false, $e->getMessage(), $e->getMessage());
        } catch (\Exception $e) {
            $this->logService->error($e->getMessage());
            return $this->apiResponse(false, __('api.something_went_wrong'), $e->getMessage());
        }
    }

    public function update(UserRequest $request, $id)
    {
        $this->logService->info('Admin users update');
        try {
            $data = $this->userService->update($request, $id);
            return $this->apiResponse(true, __('api.read'), $data);
        } catch (CustomException $e) {
            $this->logService->error($e->getMessage());
            return $this->apiResponse(false, $e->getMessage(), $e->getMessage());
        } catch (\Exception $e) {
            $this->logService->error($e->getMessage());
            return $this->apiResponse(false, __('api.something_went_wrong'), $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $this->logService->info('Admin users destroy');
        try {
            $this->userService->destroy($id);
            return $this->apiResponse(true, __('api.read'), []);
        } catch (CustomException $e) {
            $this->logService->error($e->getMessage());
            return $this->apiResponse(false, $e->getMessage(), $e->getMessage());
        } catch (\Exception $e) {
            $this->logService->error($e->getMessage());
            return $this->apiResponse(false, __('api.something_went_wrong'), $e->getMessage());
        }
    }
}
