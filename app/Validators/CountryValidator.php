<?php


namespace App\Validators;


class CountryValidator
{
    public static function validate($attribute, $value, $parameters): bool
    {
        $countries = file_get_contents(base_path('storage/all_countries.json'));
        $countries = json_decode($countries);

        return in_array(ucwords($value), $countries);
    }
}
