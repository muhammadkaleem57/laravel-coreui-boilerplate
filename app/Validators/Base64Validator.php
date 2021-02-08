<?php


namespace App\Validators;


/**
 * Class Base64Validator
 */

class Base64Validator
{
    public static function validate($attribute, $value, $parameters): bool
    {
        if (!self::isValidValue($value)) return false;

        $type = explode('/', explode(':', substr($value, 0, strpos($value, ';')))[1])[1];

        if (in_array($type, $parameters)) return true;

        return false;
    }

    public static function message($message, $attribute, $rule, $parameters){
        return str_replace(':values',join(",",$parameters), $message);
    }

    private static function isValidValue($value): bool
    {
        if (count(explode('/', $value)) < 2)
            return false;

        if (count(explode(':', substr($value, 0, strpos($value, ';')))) < 2)
            return false;

        if (count(explode('/', explode(':', substr($value, 0, strpos($value, ';')))[1])) < 2)
            return false;

        return true;
    }
}
