<?php

namespace Newride\Silicon\bundles\keycloak\Classes;

use Illuminate\Contracts\Support\Arrayable;
use Validator;

class KeycloakConnectionParameters implements Arrayable
{
    protected static $rules = [
        'authServerUrl' => 'required|url',
        'clientId' => 'required|string',
        'clientSecret' => 'required|string',
        'encryptionAlgorithm' => 'required|string',
        'encryptionKey' => 'required|string',
        'encryptionKeyPath' => 'required|string',
        'realm' => 'required|string',
        'redirectUri' => 'required|url',
    ];

    protected $authServerUrl;

    protected $clientId;

    protected $clientSecret;

    protected $encryptionAlgorithm;

    protected $encryptionKey;

    protected $encryptionKeyPath;

    protected $realm;

    protected $redirectUri;

    public static function fromArray(array $parameters): self
    {
        $validator = Validator::make($parameters, static::$rules);
        $validated = $validator->validate();

        return new static(
            $validated['authServerUrl'],
            $validated['clientId'],
            $validated['clientSecret'],
            $validated['encryptionAlgorithm'],
            $validated['encryptionKey'],
            $validated['encryptionKeyPath'],
            $validated['realm'],
            $validated['redirectUri'],
        );
    }

    public function __construct(
        string $authServerUrl,
        string $clientId,
        string $clientSecret,
        string $encryptionAlgorithm,
        string $encryptionKey,
        string $encryptionKeyPath,
        string $realm,
        string $redirectUri
    ) {
        $this->authServerUrl = $authServerUrl;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->encryptionAlgorithm = $encryptionAlgorithm;
        $this->encryptionKey = $encryptionKey;
        $this->encryptionKeyPath = $encryptionKeyPath;
        $this->realm = $realm;
        $this->redirectUri = $redirectUri;
    }

    public function getAuthServerUrl(): string
    {
        return $this->authServerUrl;
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }

    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    public function getEncryptionAlgorithm(): string
    {
        return $this->encryptionAlgorithm;
    }

    public function getEncryptionKey(): string
    {
        return $this->encryptionKey;
    }

    public function getEncryptionKeyPath(): string
    {
        return $this->encryptionKeyPath;
    }

    public function getRealm(): string
    {
        return $this->realm;
    }

    public function getRedirectUri(): string
    {
        return $this->redirectUri;
    }

    public function toArray(): array
    {
        return [
            'authServerUrl' => $this->getAuthServerUrl(),
            'clientId' => $this->getClientId(),
            'clientSecret' => $this->getClientSecret(),
            'encryptionAlgorithm' => $this->getEncryptionAlgorithm(),
            'encryptionKey' => $this->getEncryptionKey(),
            'encryptionKeyPath' => $this->getEncryptionKeyPath(),
            'realm' => $this->getRealm(),
            'redirectUri' => $this->getRedirectUri(),
        ];
    }
}
