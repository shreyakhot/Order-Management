<?php

namespace App\Http\Controllers\Api\Admin;

use App\Exceptions\CustomException;
use App\Services\Log\LogService;
use App\Services\Mail\MailService;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponseHelper;
use Illuminate\Http\Request;

/**
 * @group Admin Email
 *
 * APIs for managing email sending
 */
class MailController extends Controller
{
    use ApiResponseHelper;
    private $mailService;
    private $logService;

    public function __construct()
    {
        $this->mailService = new MailService();
        $this->logService = new LogService();
    }

    public function sendEmail(Request $request)
    {
        $this->logService->info('Admin email');
        try {
            $this->mailService->sendSimpleEmail();
            return $this->apiResponse(true, __('api.read'));
        } catch (CustomException $e) {
            $this->logService->error($e->getMessage());
            return $this->apiResponse(false, $e->getMessage(), $e->getMessage());
        } catch (\Exception $e) {
            $this->logService->error($e->getMessage());
            return $this->apiResponse(false, __('api.something_went_wrong'), $e->getMessage());
        }
    }

}
