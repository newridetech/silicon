<?php

namespace Newride\Laroak\bundles\extensions\Exceptions\Unauthorized;

use Exception;
use Newride\Laroak\bundles\extensions\Exceptions\Unauthorized;

class CannotUseExtension extends Unauthorized
{
    public function __construct(string $extension, int $code = 0, Exception $previous = null)
    {
        parent::__construct(
            sprintf('Current user can\'t use "%s" extension.', $extension),
            $code,
            $previous
        );
    }
}
