<?php


namespace App\Validators;


class AgeValidator
{
    public static function validate($attribute, $value, $parameters): bool
    {
        $minAge = (!empty($parameters)) ? (int) $parameters[0] : MIN_AGE;

        return \Carbon\Carbon::now()->diff(new \Carbon\Carbon($value))->y >= $minAge;
    }

    public static function message($message, $attribute, $rule, $parameters){
        return str_replace(':values',join(",",$parameters), $message);
    }
}
