<?php

namespace App\Http\Controllers\Api\Customer;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Http\Resources\SettingsResource;
use App\Models\Setting;
use App\Services\Log\LogService;
use App\Traits\ApiResponseHelper;
use Illuminate\Http\Request;

/**
 * @group Customer Settings
 *
 * APIs for get settings
 */
class SettingsController extends Controller
{
    use ApiResponseHelper;
    private $logService;

    public function __construct()
    {
        $this->logService = new LogService();
    }

    public function index()
    {
        $this->logService->info('Customer settings');
        try {
            $settings = Setting::get();
            $data = SettingsResource::collection($settings);
            return $this->apiResponse(true, __('api.read'), $data);
        } catch (CustomException $e) {
            $this->logService->error($e->getMessage());
            return $this->apiResponse(false, $e->getMessage(), $e->getMessage());
        } catch (\Exception $e) {
            $this->logService->error($e->getMessage());
            return $this->apiResponse(false, __('api.something_went_wrong'), $e->getMessage());
        }
    }
}
