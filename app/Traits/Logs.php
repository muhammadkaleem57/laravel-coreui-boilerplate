<?php


namespace App\Traits;


use Illuminate\Support\Facades\Auth;

trait Logs
{
    private static function onCreating($model)
    {
        if (Auth::check()) {
            $model->added_by = Auth::id();
            $model->last_updated_by = Auth::id();
        }
    }

    private static function onUpdating($model)
    {
        if ($model->isDirty()) {
            if (Auth::check()) {
                $model->last_updated_by = Auth::id();
            }
        }
    }
}
