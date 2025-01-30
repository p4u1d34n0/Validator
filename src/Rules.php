<?php
namespace FormValidation;

class Rules
{
    private static $defaultMessages = [
        'required' => "{field} is required.",
        'min' => "{field} must be at least {param} characters.",
        'max' => "{field} must not exceed {param} characters.",
        'email' => "{field} must be a valid email address.",
        'url' => "{field} must be a valid URL.",
    ];

    private static function getMessage($field, $rule, $param = null)
    {
        $message = self::$defaultMessages[$rule] ?? "$field is invalid.";
        return str_replace(['{field}', '{param}'], [$field, $param], $message);
    }

    public static function required($validator, $field, $value)
    {
        if (empty($value)) {
            $validator->addError($field, self::getMessage($field, 'required'));
        }
    }

    public static function min($validator, $field, $value, $param)
    {
        if (strlen($value) < (int)$param) {
            $validator->addError($field, self::getMessage($field, 'min', $param));
        }
    }

    public static function max($validator, $field, $value, $param)
    {
        if (strlen($value) > (int)$param) {
            $validator->addError($field, self::getMessage($field, 'max', $param));
        }
    }

    public static function email($validator, $field, $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $validator->addError($field, self::getMessage($field, 'email'));
        }
    }

    public static function url($validator, $field, $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_URL)) {
            $validator->addError($field, self::getMessage($field, 'url'));
        }
    }
}
