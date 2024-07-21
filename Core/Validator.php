<?php

namespace Core;

class Validator
{
    public static function validate($data = [], $rules = [], $config = \App\Config::class)
    {
        $errors = [];
        foreach ($rules as $field => $fieldRules) {
            $name = ucwords(str_replace("_", " ", $field));
            foreach ($fieldRules as $rule) {
                $params = explode(':', $rule);
                $rule = array_shift($params);
                if (!self::$rule($data, $field, $params)) {
                    $errors[$field][$rule] = $config::getMessage($rule, $name, $params);
                }
            }
        }
        return $errors;
    }

    /* Validation functions */
    private static function required($data, $field, $params)
    {
        return !empty($data[$field]);
    }

    private static function string($data, $field, $params)
    {
        return filter_var($data[$field], FILTER_SANITIZE_STRING);
    }

    private static function digits($data, $field, $params)
    {
        return is_numeric($data[$field]) && (isset($params[0]) ? strlen($data[$field]) == $params[0] : true);
    }

    private static function boolean($data, $field, $params)
    {
        return filter_var($data[$field], FILTER_VALIDATE_BOOLEAN) === null;
    }

    private static function confirmed($data, $field, $params)
    {
        return $data[$field] === ($data[$field . '_confirmation'] ?: null);
    }

    private static function email($data, $field, $params)
    {
        return filter_var($data[$field], FILTER_VALIDATE_EMAIL);
    }

    private static function file($data, $field, $params)
    {
        return $data[$field] instanceof UploadedFile;
    }

    private static function image($data, $field, $params)
    {
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $allowed = ['image/jpeg', 'image/gif', 'image/png', 'image/webp', 'image/svg+xml', 'image/bmp'];
        $userAllowed = @explode(',', $params[0]);
        $allowed = empty($userAllowed[0]) ? $allowed : $userAllowed;
        return $data[$field] instanceof UploadedFile &&
            array_search($finfo->file($data[$field]->getTempName()), $allowed) !== false;
    }

    private static function date($data, $field, $params)
    {
        return strtotime($data[$field]) !== false;
    }

    private static function date_equals($data, $field, $params)
    {
        return strtotime($data[$field]) == strtotime($params[0]);
    }

    private static function date_after($data, $field, $params)
    {
        return strtotime($data[$field]) > strtotime($params[0]);
    }

    private static function date_before($data, $field, $params)
    {
        return strtotime($data[$field]) < strtotime($params[0]);
    }

    private static function different($data, $field, $params)
    {
        return $data[$field] !== $data[$params[0]];
    }

    private static function same($data, $field, $params)
    {
        return $data[$field] === $data[$params[0]];
    }

    private static function present($data, $field, $params)
    {
        return key_exists($field, $data);
    }

    private static function max($data, $field, $params)
    {
        $data = $data[$field];
        if (is_numeric($data)) return (float) $data <= $params[0];
        else if (is_array($data)) return count($data) <= $params[0];
        else if ($data instanceof UploadedFile) return $data->getSize() <= $params[0];
        return strlen($data) <= $params[0];
    }

    private static function min($data, $field, $params)
    {
        $data = $data[$field];
        if (is_numeric($data)) return (float) $data >= $params[0];
        else if (is_array($data)) return count($data) >= $params[0];
        else if ($data instanceof UploadedFile) return $data->getSize() >= $params[0];
        return strlen($data) >= $params[0];
    }
}