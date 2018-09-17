<?php

namespace Newride\Silicon\bundles\content\Models;

use Alsofronie\Uuid\UuidModelTrait;
use Illuminate\Database\Eloquent\Model;
use Newride\Silicon\bundles\content\Contracts\StaticContent as StaticContentContract;
use Newride\Silicon\bundles\content\Exceptions\ContentNotFound;

class StaticContent extends Model implements StaticContentContract
{
    use UuidModelTrait;

    public $casts = [
        'data' => 'array',
    ];

    public $guarded = [
        'id',
        'owner_id',
        'owner_type',
    ];

    public $table = 'laroak_static_contents';

    public function get(string $field, string $fallback = null): string
    {
        try {

            if ($this->has($field)) {
                return (string)$this->data[$field];
            }

            if (is_null($fallback)) {
                throw new ContentNotFound($field);
            }

        } catch (\Exception $e) {
            report($e);
        }

        return (string) $fallback;
    }

    public function has(string $field): bool
    {
        return array_key_exists($field, $this->data);
    }

    public function isLocale(string $locale): bool
    {
        return $locale === $this->locale;
    }

    public function owner()
    {
        return $this->morphTo();
    }

    public function set(string $field, string $value): StaticContentContract
    {
        $this->data = array_merge($this->data, [
            $field => $value,
        ]);

        return $this;
    }
}
