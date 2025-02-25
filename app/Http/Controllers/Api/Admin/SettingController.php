<?php

namespace App\Http\Controllers\Api\Admin;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Http\Filters\SettingFilter;
use App\Http\Resources\SettingsResource;
use App\Models\Setting;
use App\Services\Log\LogService;
use App\Traits\ApiResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

/**
 * @group Admin Settings
 *
 * APIs for managing settings
 */
class SettingController extends Controller
{
    use ApiResponseHelper;
    private $logService;

    public function __construct()
    {
        $this->logService = new LogService();
    }

    public function index(Request $request)
    {
        $this->logService->info('Admin settings');
        try {
            $settings = Setting::filter($request->all(), SettingFilter::class)->get();
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

    public function update(Request $request)
    {
        $this->logService->info('Admin settings update');
        $inputs = $request->all();
        try {
            $results = DB::transaction(function () use ($inputs) {
                foreach ($inputs as $key => $value) {
                    $setting = Setting::where('key', $key)->first();
                    if (isset($setting) && $setting->required == 1 && $value == '') {
                        throw new CustomException($key . ' is required field');
                    }
                    if ($setting) {
                        $setting->value = $value;
                        $setting->save();
                    }
                }
                return Setting::get();
            });
            $data = SettingsResource::collection($results);
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
