<?php

namespace App\Services\Log;

use Illuminate\Support\Facades\Log;

class LogService
{
    public function info($message)
    {
        Log::info($this->exceptionDetails($message));
    }

    public function error($message)
    {
        Log::error($this->exceptionDetails($message));
    }

    public function warning($message)
    {
        Log::emergency($this->exceptionDetails($message));
    }

    public function debug($message)
    {
        Log::emergency($this->exceptionDetails($message));
    }

    public function fetal($message)
    {
        Log::emergency($this->exceptionDetails($message));
    }

    public function exceptionDetails($message){
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 2);

        // Get the class's name and method
        $class = $backtrace[1]['class'];
        $method = $backtrace[1]['function'];

        // Get the relative path to the controller from the base path
        //$fileInfo = $backtrace[0]['file'];  //enable and use this if need complete file path

        // Create the log format
        return $logInfo =" Class => {$class} Function => {$method}(lineNo: {$backtrace[0]['line']}) Message => {$message}";
    }
}