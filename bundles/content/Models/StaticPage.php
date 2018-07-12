<?php

namespace Newride\Silicon\bundles\content\Models;

use Alsofronie\Uuid\UuidModelTrait;
use App;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\Request;
use Newride\Silicon\bundles\content\Contracts\StaticContent as StaticContentContract;
use Newride\Silicon\bundles\content\Contracts\StaticContentOwner;
use Newride\Silicon\bundles\content\Exceptions\LocaleNotFound;

class StaticPage extends Model implements StaticContentOwner
{
    use UuidModelTrait;

    public $guarded = [
        'id',
    ];

    public $table = 'silicon_static_pages';

    public static function findOneByRequestOrFail(Request $request): self
    {
        return static::request($request)->firstOrFail();
    }

    public function content(string $locale = null): StaticContentContract
    {
        if (is_null($locale)) {
            $locale = App::getLocale();
        }

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
