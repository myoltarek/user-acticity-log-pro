<?php

namespace Tarek\UserActivityLog\Traits;

use Tarek\UserActivityLog\Helpers\ActivityLogger;

trait LogActivity
{
    public static function bootLogActivity()
    {
        static::created(function ($model) {
            ActivityLogger::log('create', 'Created '.class_basename($model), [
                'model' => get_class($model),
                'model_id' => $model->id,
                'new_data' => $model->toArray(),
            ]);
        });

        static::updating(function ($model) {
            $dirty = $model->getDirty();

            if (empty($dirty)) return;

            ActivityLogger::log('update', 'Updated '.class_basename($model), [
                'model' => get_class($model),
                'model_id' => $model->id,
                'old_data' => array_intersect_key($model->getOriginal(), $dirty),
                'new_data' => $dirty,
            ]);
        });

        static::deleted(function ($model) {
            ActivityLogger::log('delete', 'Deleted '.class_basename($model), [
                'model' => get_class($model),
                'model_id' => $model->id,
                'old_data' => $model->toArray(),
            ]);
        });
    }
}
