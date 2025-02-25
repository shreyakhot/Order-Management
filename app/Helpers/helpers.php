<?php

if (!function_exists('generateRefNo')) {
    function generateRefNo($prefix)
    {
        // Generate a UUID
        $uuid = Str::random(6);
        // Concatenate the prefix, UUID, and timestamp
        return strtoupper($prefix . $uuid . time());
    }
}
