<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogger
{
    /**
     * Log an activity.
     *
     * @param string $action
     * @param mixed $model
     * @param array|null $oldValues
     * @param array|null $newValues
     * @return ActivityLog
     */
    public function log(
        string $action,
        $model = null,
        ?array $oldValues = null,
        ?array $newValues = null
    ): ActivityLog {
        $data = [
            'user_id' => Auth::id(),
            'action' => $action,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ];

        if ($model) {
            $data['model_type'] = get_class($model);
            $data['model_id'] = $model->id ?? null;
        }

        if ($oldValues) {
            $data['old_values'] = $this->sanitizeValues($oldValues);
        }

        if ($newValues) {
            $data['new_values'] = $this->sanitizeValues($newValues);
        }

        return ActivityLog::create($data);
    }

    /**
     * Log a model creation.
     *
     * @param mixed $model
     * @return ActivityLog
     */
    public function logCreated($model): ActivityLog
    {
        return $this->log('created', $model, null, $model->getAttributes());
    }

    /**
     * Log a model update.
     *
     * @param mixed $model
     * @param array $oldValues
     * @return ActivityLog
     */
    public function logUpdated($model, array $oldValues): ActivityLog
    {
        return $this->log('updated', $model, $oldValues, $model->getAttributes());
    }

    /**
     * Log a model deletion.
     *
     * @param mixed $model
     * @return ActivityLog
     */
    public function logDeleted($model): ActivityLog
    {
        return $this->log('deleted', $model, $model->getAttributes(), null);
    }

    /**
     * Log user login.
     *
     * @return ActivityLog
     */
    public function logLogin(): ActivityLog
    {
        return $this->log('logged_in');
    }

    /**
     * Log user logout.
     *
     * @return ActivityLog
     */
    public function logLogout(): ActivityLog
    {
        return $this->log('logged_out');
    }

    /**
     * Sanitize values to hide sensitive data.
     *
     * @param array $values
     * @return array
     */
    protected function sanitizeValues(array $values): array
    {
        $sensitiveKeys = ['password', 'password_confirmation', 'remember_token', 'api_token'];

        foreach ($sensitiveKeys as $key) {
            if (isset($values[$key])) {
                $values[$key] = '***hidden***';
            }
        }

        return $values;
    }
}
