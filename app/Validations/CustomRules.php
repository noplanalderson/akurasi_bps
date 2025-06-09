<?php

namespace App\Validations;
use CodeIgniter\Validation\StrictRules\FormatRules;
use Config\Database;
use CodeIgniter\Database\Exceptions\DataException;
use App\Validations\UUIDv7Validation;

class CustomRules
{
    public function check_id(string $str, string $fields, array $data, ?string &$error = null): bool
    {
        [$actionField, $idField] = array_pad(
            explode(',', $fields),
            3,
            null
        );

        $check = is_int($str);

        if ($data[$actionField] === 'edit' && empty($data[$idField]) && !$check) {
            return false;
        }

        return true;
    }

    public function is_unique_custom($str, string $field, array $data): bool
    {
        if (is_object($str) || is_array($str)) {
            return false;
        }

        [$field, $ignoreField, $ignoreValue, $exclude_deleted] = array_pad(
            explode(',', $field),
            4,
            null
        );

        sscanf($field, '%[^.].%[^.]', $table, $field);

        $where = ($exclude_deleted == 'true') ? array($field => $str, 'deleted_at' => null) : array($field => $str);
        $row = Database::connect($data['DBGroup'] ?? null)
            ->table($table)
            ->select('1')
            ->where($where)
            ->limit(1);

        if($data['action'] === 'edit') {
            if (
                $ignoreField !== null && $ignoreField !== ''
                && $data[$ignoreValue] !== null && $data[$ignoreValue] !== ''
                && ! preg_match('/^\{(\w+)\}$/', $data[$ignoreValue])
            ) {
                $row = $row->where("{$ignoreField} !=", $data[$ignoreValue]);
            }
        }

        return $row->get()->getRow() === null;
    }

    public function is_uuid(string $str, string &$error = null): bool
    {
        return (bool) preg_match(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i',
            $str
        );
    }

    public function check_uuid(string $str, string $fields, array $data, ?string &$error = null): bool
    {
        [$actionField, $idField] = array_pad(
            explode(',', $fields),
            3,
            null
        );

        $check = $this->is_uuid($str);

        if ($data[$actionField] === 'edit' && empty($data[$idField]) && !$check) {
            return false;
        }

        return true;
    }

    /**
     * Validates that the input string is a valid UUIDv7 and meets additional conditions.
     *
     * @param string|null $str The input string to validate
     * @param string $fields Comma-separated fields (actionField,idField)
     * @param array $data Other form data
     * @param string|null $error Custom error message
     * @return bool
     * @throws ValidationException
     */
    public function check_uuid7(?string $str, string $fields, array $data, ?string &$error = null): bool
    {
        // Extract actionField and idField from $fields
        [$actionField, $idField] = array_pad(
            explode(',', $fields),
            2,
            null
        );
        
        // Validate $str as UUIDv7
        $isValidUuid = $this->uuid7($str);

        // If action is 'edit', check if idField is empty and UUID is invalid
        if ($data[$actionField] === 'edit' && empty($data[$idField]) && !$isValidUuid) {
            return false;
        }

        // Return true if UUID is valid or no additional checks fail
        return true;
    }

    public static function uuid7(?string $str, ?string &$error = null): bool
    {
        // Check if input is null or empty
        if (empty($str)) {
            // $error = 'The '.$field.' field must be a valid UUIDv7.';
            return false;
        }

        // UUIDv7 regex: 8-4-4-4-12 hex chars, version 7
        $uuidPattern = '/^[0-9a-f]{8}-[0-9a-f]{4}-7[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i';

        if (!preg_match($uuidPattern, $str)) {
            // $error = 'The '.$field.' field must be a valid UUIDv7 format.';
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
            // $error = 'The '.$field.' field contains an invalid UUIDv7 timestamp.';
            return false;
        }

        return true;
    }

    public function valid_phone(string $str): bool
    {
        return (bool) preg_match('/^(?:\+62|62|0)[2-9][0-9]{7,14}$/', $str);
    }

    public function valid_person_name(string $str, string &$error = null): bool
    {
        if ($str === null) {
            return false;
        }

        if (! is_string($str)) {
            $str = (string) $str;
        }

        return preg_match('/^[a-z \'.,]{3,100}$/i', $str) === 1;
    }

    public function valid_base64_image(string $str, string &$error = null): bool
    {
        $pattern = '/^data:image\/(png|jpg|jpeg|gif|bmp|webp);base64,([A-Za-z0-9+\/]+={0,2})$/';
        if (!preg_match($pattern, $str, $matches)) {
            $error = 'Invalid base64 image format.';
            return false;
        }

        $image_data = base64_decode($matches[2]);

        if ($image_data === false) {
            $error = 'Failed to decode base64 image.';
            return false;
        }

        $tmp_file = tempnam(sys_get_temp_dir(), 'img_');
        file_put_contents($tmp_file, $image_data);

        $image_info = getimagesize($tmp_file);
        if ($image_info === false) {
            unlink($tmp_file);
            $error = 'The decoded base64 string is not a valid image.';
            return false;
        }

        $valid_mime_types = ['image/png', 'image/jpeg', 'image/gif', 'image/bmp', 'image/webp'];
        if (!in_array($image_info['mime'], $valid_mime_types)) {
            unlink($tmp_file);
            $error = 'Invalid image MIME type: ' . $image_info['mime'];
            return false;
        }

        $max_size = 5 * 1024 * 1024;
        if (strlen($image_data) > $max_size) {
            unlink($tmp_file);
            $error = 'Image size exceeds the maximum allowed limit of 5MB.';
            return false;
        }

        unlink($tmp_file);
        return true;
    }
}
