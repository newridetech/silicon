<?php

namespace Newride\Laroak\bundles\content\Models;

use Alsofronie\Uuid\UuidModelTrait;
use Illuminate\Database\Eloquent\Model;
use Newride\Laroak\bundles\content\Contracts\StaticContentOwner;
use Newride\Laroak\bundles\content\Contracts\StaticContent as StaticContentContract;
use Newride\Laroak\bundles\content\Exceptions\ContentNotFound;

class StaticContent extends Model implements StaticContentContract
{
    use UuidModelTrait;

    public $casts = [
        'data' => 'array',
    ];

    public $table = 'laroak_static_contents';

    public function get(string $field, string $fallback = null): string
    {
        if ($this->has($field)) {
            return $this->data[$field];
        }

        if (is_null($fallback)) {
            throw new ContentNotFound($field);
        }

        return $fallback;
    }

    public function has(string $field): bool
    {
        return array_key_exists($field, $this->data);
    }

    public function isLocale(string $locale): bool
    {
        return $locale === $this->locale;
    }

    public function setOwner(StaticContentOwner $staticContentOwner): void
    {
        $this->owner_id = $staticContentOwner->contentOwnerId();
    }
}
