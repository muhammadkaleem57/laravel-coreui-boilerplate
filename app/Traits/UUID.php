<?php


namespace App\Traits;


trait UUID
{
    protected static function generateUUId($model, $column = 'uuid', $prefix = 'ch')
    {
        if (get_class($model) === 'App\Models\User')
            $existed_uuid = $model::latest()->first();
        else
            $existed_uuid = $model::pluck($column)->toArray();

        return self::generateUUIdString($model, $existed_uuid, $prefix, $column);
    }

    private static function generateUUIdString($model, $existed_uuid, $prefix, $column = null)
    {
        if (get_class($model) === 'App\Models\User')
            return self::generateUserUuid($existed_uuid, $column);

        $id_str = $prefix.\Ramsey\Uuid\Uuid::uuid4()->toString();

        if (in_array($id_str, $existed_uuid))
            return self::generateUUIdString($model, $existed_uuid, $prefix);

        return $id_str;
    }

    private static function generateUserUuid($last_user, $column)
    {
        # if it's the first iteration
        if (is_null($last_user))
            return strtoupper(USER_UUID);

        $existing_char = substr($last_user->$column, 0, 2);
        $digit = substr($last_user->$column, 2);

        if ($digit !== USER_END_UUID_DIGIT)
            return $existing_char.self::formatUserUuidDigit($digit);

        return self::generateUserUuidCombination($existing_char);
    }

    /**
     * @param string $digit
     * @return int|string
     */
    private static function formatUserUuidDigit($digit)
    {
        $digit = (int)$digit + 1;

        if (strlen($digit) === 1)
            $digit = '000' . $digit;
        else if (strlen($digit) === 2)
            $digit = '00' . $digit;

        else if (strlen($digit) === 3)
            $digit = '0' . $digit;

        return $digit;
    }

    /**
     * @param string $existing_char
     * @return string|null
     */
    private static function generateUserUuidCombination($existing_char)
    {
        $chars = $combinations = chars();
        $uuid = null;

        # loop through existing combinations and character set to create strings
        foreach ($combinations as $combination) {
            if (!is_null($uuid)) break;

            foreach ($chars as $key => $char) {
                if (strtoupper($combination . $char) === strtoupper($existing_char)) {
                    if ($key+1 !== $chars->count()) {
                        $uuid = $combination . $chars[$key + 1] . USER_START_UUID_DIGIT;
                        break;
                    }
                }
            }
        }

        return $uuid;
    }
}
