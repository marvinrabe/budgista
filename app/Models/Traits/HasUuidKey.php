<?php

namespace App\Models\Traits;

use Exception;
use Ramsey\Uuid\Uuid;

trait HasUuidKey
{
    /**
     * Indicates if the IDs are UUIDs.
     *
     * @var bool
     */
    protected $keyIsUuid = true;

    /**
     * The UUID version to use.
     *
     * @var int
     */
    protected $uuidVersion = 4;

    /**
     * This function overwrites the default boot static method of Eloquent models. It will hook
     * the creation event with a simple closure to insert the UUID
     */
    public static function bootHasUuidKey()
    {
        static::creating(function (self $model): void {
            // Automatically generate a UUID if using them, and not provided.
            if ($model->keyIsUuid && empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = $model->generateUuid();
            }
        });
    }

    /**
     * Overwrite default parameter values.
     */
    public function initializeHasUuidKey() {
        $this->keyType = 'string';
        $this->incrementing = false;
    }

    /**
     * @return string
     * @throws \Exception
     */
    protected function generateUuid(): string
    {
        switch ($this->uuidVersion) {
            case 1:
                return Uuid::uuid1()->toString();
            case 4:
                return Uuid::uuid4()->toString();
        }

        throw new Exception("UUID version [{$this->uuidVersion}] not supported.");
    }
}
