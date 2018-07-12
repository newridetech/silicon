<?php

namespace Newride\Silicon\bundles\content\Exceptions;

use Newride\Silicon\bundles\content\Exception;

class LocaleNotFound extends Exception
{
    public function __construct(string $locale)
    {
        parent::__construct(sprintf('Expected locale "%s" was not found.', $locale));
    }
}
