<?php


namespace App\Helpers;


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class ExceptionLog
{
    public static function exception($exception, $file_name = 'User'){

        $file = $file_name.'-Exception.json';
        $storage = Storage::disk('log');

        $data = [
            'data_time' => date('Y-m-d H:i:s'),
            'url' => request()->url(),
            'file' => Route::currentRouteAction(),
            'method' => request()->route()->getActionName(),
            'status' => $exception->getCode(),
            'line' => $exception->getLine(),
            'message' => $exception->getMessage(),
        ];

        $file_info = self::getFileData($storage, $file);

        if (is_array($file_info)) {
            array_push($file_info, $data);

            $storage->put($file, json_encode($file_info));
        }
    }

    public static function exceptionLogsList(): array
    {
        $storage = Storage::disk('log');

        $all_list = $user_file_list = self::getFileData($storage);

        $admin_file_list = self::getFileData($storage, 'Admin-Exception.json');
        if (count($admin_file_list))
            $all_list = array_merge($admin_file_list, $all_list);

        $all_list = _array_reverse($all_list);
        $user_file_list = _array_reverse($user_file_list);
        $admin_file_list = _array_reverse($admin_file_list);

        return compact('all_list', 'admin_file_list', 'user_file_list');
    }

    private static function getFileData($storage, $file = 'User-Exception.json'): ?array
    {
        return $storage->exists($file) ? json_decode($storage->get($file)) : [];
    }

    public static function clearLogs($type): array
    {
        $storage = Storage::disk('log');

        if ((int) $type === SUPER_ADMIN){
            self::clearFileLogs($storage);
            self::clearFileLogs($storage, 'Admin-Exception.json');
        }
        else if ((int) $type === USER)
            self::clearFileLogs($storage);


        return self::exceptionLogsList();
    }

    private static function clearFileLogs($storage, $file_name = 'User-Exception.json'){

        $storage->put($file_name, json_encode([]));
    }
}
