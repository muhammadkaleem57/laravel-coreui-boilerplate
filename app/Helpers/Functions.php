<?php



function _array_reverse($array): array
{
    return count($array) ? array_reverse($array) : [];
}

function decodedData($request, $field, $type = false){
    return is_array($request->$field) ? json_decode(json_encode($request->$field), $type) :
        json_decode($request->$field, $type);
}

function nullToString($value): ?string
{
    return $value ?? '';
}

function formatDate($date): string
{
    if (nullToString($date) !== '')
        return \Carbon\Carbon::parse($date)->format(DATE_FORMAT);

    return '';
}

function chars(): array
{
    return range('A','Z');
}
