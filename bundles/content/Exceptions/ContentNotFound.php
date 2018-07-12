<?php

namespace Newride\Silicon\bundles\content\Exceptions;

use Newride\Silicon\bundles\content\Exception;

class ContentNotFound extends Exception
{
    public function __construct(string $contentPath)
    {
        parent::__construct(sprintf('Expected content "%s" was not found.', $contentPath));
    }
}
