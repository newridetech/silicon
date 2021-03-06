<?php

declare(strict_types=1);

namespace Newride\Silicon\bundles\keycloak\Auth\Guard;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Session\Session;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Newride\Silicon\bundles\keycloak\Auth\UserProvider\Keycloak as KeycloakUserProvider;
use Newride\Silicon\bundles\keycloak\Classes\AuthenticatedUserContainer;
use Newride\Silicon\bundles\keycloak\Exceptions\NotSupported;
use pviojo\OAuth2\Client\Provider\Keycloak as KeycloakClient;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class KeycloakSession implements StatefulGuard
{
    protected $keycloak;
    protected $provider;
    protected $session;
    protected $userContainer;

    public function __construct(AuthenticatedUserContainer $userContainer, KeycloakClient $keycloak, KeycloakUserProvider $provider, Session $session)
    {
        $this->keycloak = $keycloak;
        $this->provider = $provider;
        $this->session = $session;
        $this->userContainer = $userContainer;
    }

    /**
     * Attempt to authenticate a user using the given credentials.
     *
     * @param array $credentials
     * @param bool  $remember
     *
     * @return bool
     */
    public function attempt(array $credentials = [], $remember = false): bool
    {
        if (!$this->validate($credentials)) {
            throw new UnauthorizedHttpException('Keycloak', 'Given credentials are not valid.');
        }

        $user = $this->provider->retrieveByCredentials($credentials);

        if (!$user) {
            return false;
        }

        if (!$this->provider->validateCredentials($user, $credentials)) {
            return false;
        }

        $this->login($user, $remember);

        return true;
    }

    /**
     * Determine if the current user is authenticated.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function authenticate(): Authenticatable
    {
        if (!is_null($user = $this->user())) {
            return $user;
        }

        throw new AuthenticationException();
    }

    /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function check(): bool
    {
        return !is_null($this->user());
    }

    /**
     * Get a unique identifier for the auth session value.
     *
     * @return string
     */
    public function getName()
    {
        return 'login_keycloak';
    }

    /**
     * Get the user provider used by the guard.
     *
     * @return \Newride\Silicon\bundles\keycloak\Auth\UserProvider\Keycloak
     */
    public function getProvider(): KeycloakUserProvider
    {
        return $this->provider;
    }

    /**
     * Determine if the current user is a guest.
     *
     * @return bool
     */
    public function guest(): bool
    {
        return !$this->check();
    }

    /**
     * Get the ID for the currently authenticated user.
     *
     * @return int|null
     */
    public function id(): ?string
    {
        if ($this->user()) {
            return $this->user()->getAuthIdentifier();
        }
    }

    /**
     * Log a user into the application.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @param bool                                       $remember
     */
    public function login(Authenticatable $user, $remember = false): void
    {
        $this->session->put($this->getName(), serialize($user->getAccessToken()));
        // $this->session->migrate(true);

        $this->setUser($user);
    }

    /**
     * Log the given user ID into the application.
     *
     * @param mixed $id
     * @param bool  $remember
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    public function loginUsingId($id, $remember = false)
    {
        throw NotSupported::authenticationWithoutCredentials();
    }

    /**
     * Log the user out of the application.
     */
    public function logout()
    {
        $this->session->flush();

        // remove user from memory also
        $this->userContainer->removeUser();
    }

    /**
     * Log a user into the application without sessions or cookies.
     *
     * @param array $credentials
     *
     * @return bool
     */
    public function once(array $credentials = [])
    {
        throw NotSupported::stateless();
    }

    /**
     * Log the given user ID into the application without sessions or cookies.
     *
     * @param mixed $id
     *
     * @return bool
     */
    public function onceUsingId($id)
    {
        throw NotSupported::stateless();
    }

    /**
     * Set the current user.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     *
     * @return $this
     */
    public function setUser(Authenticatable $user): self
    {
        $this->userContainer->setUser($user);

        return $this;
    }

    public function user(): ?Authenticatable
    {
        if ($this->userContainer->hasUser()) {
            return $this->userContainer->getUser();
        }

        $accessToken = $this->session->get($this->getName());
        if (!$accessToken) {
            return null;
        }

        $accessToken = unserialize($accessToken);

        try {
            $user = $this->provider->retrieveByAccessToken($accessToken);
        } catch (IdentityProviderException $e) {
            if (false !== strpos($e->getMessage(), 'session not found')) {
                // user has logged out from Keycloak but token is still stored in a
                // session
                return null;
            }

            throw $e;
        }

        if (empty($user)) {
            return null;
        }

        $this->setUser($user);

        return $this->userContainer->getUser();
    }

    /**
     * Validate a user's credentials.
     *
     * @param array $credentials
     *
     * @return bool
     */
    public function validate(array $credentials = []): bool
    {
        if (!array_key_exists('code', $credentials)) {
            return false;
        }

        $state = $this->session->pull('keycloak_provider_state');

        return request()->state === $state;
    }

    /**
     * Determine if the user was authenticated via "remember me" cookie.
     *
     * @return bool
     */
    public function viaRemember()
    {
        return false;
    }
}
