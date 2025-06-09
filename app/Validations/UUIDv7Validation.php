<?php

namespace App\Validations;

use CodeIgniter\Validation\Exceptions\ValidationException;

class UUIDv7Validation
{
    /**
     * Validates that the input is a valid UUID version 7.
     *
     * @param string|null $str The input string to validate
     * @param string $fields Field name (not used here)
     * @param array $data Other form data (not used here)
     * @param string|null $error Custom error message (optional)
     * @return bool
     * @throws ValidationException
     */
    public static function uuid_v7(?string $str, string $fields, array $data, ?string &$error = null): bool
    {
        // Check if input is null or empty
        if (empty($str)) {
            $error = 'The {field} field must be a valid UUIDv7.';
            return false;
        }

        // UUIDv7 regex: 8-4-4-4-12 hex chars, version 7
        $uuidPattern = '/^[0-9a-f]{8}-[0-9a-f]{4}-7[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i';

        if (!preg_match($uuidPattern, $str)) {
            $error = 'The {field} field must be a valid UUIDv7 format.';
            return false;
        }

        // Extract timestamp (first 8 hex chars represent milliseconds since Unix epoch)
        $timestampHex = substr($str, 0, 8);
        $timestampMs = hexdec($timestampHex);

        // Convert to seconds for comparison
        $timestampSec = $timestampMs / 1000;

        // Validate timestamp is reasonable (e.g., between 1970 and 10 years from now)
        $currentTime = time();
        $maxFutureTime = $currentTime + (10 * 365 * 24 * 3600); // 10 years in seconds
        $unixEpochStart = 0; // 1970-01-01

        if ($timestampSec < $unixEpochStart || $timestampSec > $maxFutureTime) {
            $error = 'The {field} field contains an invalid UUIDv7 timestamp.';
            return false;
        }

        return true;
    }
}