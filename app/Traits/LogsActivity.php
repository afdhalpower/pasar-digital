<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    public static function bootLogsActivity(): void
    {
        static::created(function (Model $model) {
            static::logChange($model, 'created');
        });

        static::updated(function (Model $model) {
            static::logChange($model, 'updated');
        });

        static::deleted(function (Model $model) {
            static::logChange($model, 'deleted');
        });
    }

    protected static function logChange(Model $model, string $action): void
    {
        if (!Auth::check() || Auth::user()->isAdmin()) {
            $user = Auth::user();
        } else {
            $user = null;
        }

        $dirty = $model->getDirty();
        $changes = [];

        if ($action === 'updated') {
            foreach ($dirty as $key => $value) {
                if (in_array($key, ['updated_at', 'created_at'])) continue;
                $original = $model->getOriginal($key);
                $changes[$key] = ['from' => $original, 'to' => $value];
            }
        }

        ActivityLog::create([
            'user_id' => $user?->id,
            'action' => $action,
            'description' => static::getLogDescription($model, $action),
            'subject_type' => get_class($model),
            'subject_id' => $model->getKey(),
            'properties' => $action === 'updated' ? $changes : null,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    protected static function getLogDescription(Model $model, string $action): string
    {
        $name = method_exists($model, 'getNameForLog') ? $model->getNameForLog() : ($model->name ?? $model->id);

        $label = class_basename($model);

        return match ($action) {
            'created' => "{$label} \"{$name}\" dibuat",
            'updated' => "{$label} \"{$name}\" diperbarui",
            'deleted' => "{$label} \"{$name}\" dihapus",
            default => "{$label} \"{$name}\" {$action}",
        };
    }

    public static function log(string $action, string $description, ?Model $subject = null): void
    {
        $user = Auth::user();

        ActivityLog::create([
            'user_id' => $user?->id,
            'action' => $action,
            'description' => $description,
            'subject_type' => $subject ? get_class($subject) : null,
            'subject_id' => $subject?->getKey(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
