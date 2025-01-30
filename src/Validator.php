<?php

namespace FormValidation;

class Validator
{
    private $data = [];
    private $rules = [];
    private $errors = [];
    private static $customRules = [];
    private $customMessages = [];

    public static function validate(array $rules, array $data = null, array $messages = [])
    {
        $instance = new self();
        $instance->data = $data ?? $_POST;
        $instance->rules = $rules;
        $instance->customMessages = $messages;
        $instance->applyRules();
        return $instance;
    }

    private function applyRules()
    {
        foreach ($this->rules as $field => $fieldRules) {
            $value = $this->data[$field] ?? null;

            foreach ($fieldRules as $rule) {
                if (strpos($rule, ':') !== false) {
                    [$ruleName, $parameter] = explode(':', $rule, 2);
                } else {
                    $ruleName = $rule;
                    $parameter = null;
                }

                // Use external rules file
                if (method_exists(Rules::class, $ruleName)) {
                    Rules::$ruleName($this, $field, $value, $parameter);
                } elseif (isset(self::$customRules[$ruleName])) {
                    call_user_func(self::$customRules[$ruleName], $this, $field, $value, $parameter);
                } else {
                    $this->addError($field, "Validation rule $ruleName does not exist.");
                }
            }
        }
    }

    public function addError($field, $message)
    {
        $this->errors[$field][] = $message;
    }

    public function passed()
    {
        return empty($this->errors);
    }

    public function errors()
    {
        return $this->errors;
    }

    public static function addRule(string $name, callable $callback)
    {
        self::$customRules[$name] = $callback;
    }
}
