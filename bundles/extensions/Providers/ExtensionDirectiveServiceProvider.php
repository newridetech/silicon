<?php

namespace Newride\Silicon\bundles\extensions\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class ExtensionDirectiveServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Blade::directive('extension', function (string $name) {
            return '<?php if (Extensions::canUse('.$name.', Auth::user())): ?>';
        });

        Blade::directive('endextension', function () {
            return '<?php endif; ?>';
        });
    }
}
