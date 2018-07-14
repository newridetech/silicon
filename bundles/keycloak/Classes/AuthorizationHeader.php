<?php

declare(strict_types=1);

namespace Newride\Silicon\bundles\keycloak\Classes;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use League\OAuth2\Client\Token\AccessToken;

class AuthorizationHeader
{
    public $header;

    public static function fromRequest(Request $request = null): self
    {
        if (is_null($request)) {
            $request = request();
        }

        return new static($request->header('Authorization') ?? '');
    }

    public function __construct(string $header)
    {
        $this->header = $header;
    }

    public function getAccessToken(): ?AccessToken
    {
        $bearer = $this->getBearer();

        if (is_null($bearer)) {
            return null;
        }

        return new AccessToken([
            'access_token' => $bearer,
        ]);
    }

    public function getBearer(): ?string
    {
        if (!$this->hasAccessToken()) {
            return null;
        }

        $chunks = explode(' ', $this->header);

        return array_pop($chunks);
    }

    public function hasAccessToken(): bool
    {
        return Str::startsWith($this->header, 'Bearer ')
            && 'Bearer' !== trim($this->header)
        ;
    }
}
