<?php

namespace Recruitment\MailTask\Service;

class Validator
{
    private $rawData;
    private $validatedData;
    private $errors;

    public function __construct($fields, $rawData = null)
    {
        if (!$rawData) {
            $rawData = $_POST;
        }

        $this->rawData = $rawData;

        foreach ($fields as $field) {
            list($fieldName, $validator) = $field;
            $fieldValue = $this->getField($fieldName);
            if (empty($fieldValue)) {
                $this->errors[$fieldName] = 'Cannot be empty';
                continue;
            }

            if (!method_exists($this, $validator)) {
                $this->errors[$fieldName] = 'Unknown type';
                continue;
            }

            $this->validatedData[$fieldName] = $this->$validator($fieldName, $fieldValue);
        }
    }

    private function getField($fieldName)
    {
        return $this->rawData[$fieldName] ?? '';
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getData(): array
    {
        return $this->validatedData;
    }

    private function emailType($name, $value): string
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$name] = 'Not a valid Email';
        }

        return $value;
    }

    private function plainTextType($name, $value): string
    {
        $value = addslashes($value);

        return $value;
    }

    private function plainEmailBodyType($name, $value): string
    {
        $value = htmlentities(strip_tags($value));

        return $value;
    }
}
