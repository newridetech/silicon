<?php

namespace Newride\Laroak\bundles\content\Models;

use Newride\Laroak\bundles\content\Contracts\StaticContent as StaticContentContract;
use Newride\Laroak\bundles\content\Contracts\StaticContentOwner;
use Newride\Laroak\bundles\content\Exceptions\LocaleNotFound;
use Alsofronie\Uuid\UuidModelTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\Request;

class StaticPage extends Model implements StaticContentOwner
{
    use UuidModelTrait;

    public $guarded = [
        'id',
    ];

    public $table = 'laroak_static_pages';

    public static function findOneByRequestOrFail(Request $request): self
    {
        return static::request($request)->firstOrFail();
    }

    public function content(string $locale): StaticContentContract
    {
        foreach ($this->contents as $content) {
            if ($content->isLocale($locale)) {
                return $content;
            }
        }

        throw new LocaleNotFound($locale);
    }

    public function contents(): MorphMany
    {
        return $this->morphMany(StaticContent::class, 'owner');
    }

    public function scopeRequest(Builder $query, Request $request): Builder
    {
        $routeName = $request->route()->getName();

        return $this->scopeRoute($query, $routeName);
    }

    public function scopeRoute(Builder $query, string $routeName): Builder
    {
        return static::where('route', $routeName);
    }
}
