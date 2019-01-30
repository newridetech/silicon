<?php

declare(strict_types=1);

namespace Newride\Silicon\bundles\keycloak\Classes;

use Illuminate\Support\Collection;
use Newride\Silicon\bundles\keycloak\Exceptions\Keycloak\Authorization\Roles as RolesException;
use Newride\Silicon\bundles\keycloak\Exceptions\Keycloak\GroupNotFound;

class KeycloakClient
{
    protected $client;

    public function __construct(HttpClient $client)
    {
        $this->client = $client;
    }

    public function addGroupMemberByGroupName(string $name, string $id): void
    {
        $group = $this->getGroupByName($name);

        $this->addGroupMembersByGroup($group['id'], $id);
    }

    public function addGroupMembersByGroup(string $groupId, string $userId): void
    {
        $this->client->realm('PUT', '/users/'.$userId.'/groups/'.$groupId, [], [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            'body' => json_encode([
                'groupId' => $groupId,
                'realm' => $this->client->getRealm(),
                'userId' => $userId,
            ]),
        ]);
    }

    public function createUser(array $parameters): array
    {
        $this->client->realm('POST', '/users', [], [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            'body' => json_encode($parameters),
        ]);

        return $this->getUserByUsername($parameters['username']);
    }

    public function getGroupByName(string $name): array
    {
        $groups = $this->client->realm('GET', '/groups', [
            'search' => $name,
        ]);

        foreach ($groups as $group) {
            if ($group['name'] === $name) {
                return $group;
            }
        }

        throw new GroupNotFound($name);
    }

    public function getGroupMembers(string $name): Collection
    {
        $group = $this->getGroupByName($name);

        if (is_null($group)) {
            throw new GroupNotFound($name);
        }

        $members = $this->client->realm('GET', '/groups/'.$group['id'].'/members');

        if (empty($members)) {
            return collect([]);
        }

        return collect($members);
    }

    public function getUser(string $id): ?array
    {
        $user = $this->client->realm('GET', '/users/'.$id);

        return $user ? $user : [];
    }

    public function getUserByUsername(string $username): ?array
    {
        return head($this->getUsers([
            'username' => $username,
        ]));
    }

    public function getUsers(array $options = []): array
    {
        $response = $this->client->realm('GET', '/users', $options);

        if (!is_array($response)) {
            throw new RolesException('realm-management', [
                'query-users',
                'view-users',
            ], 'view users list');
        }

        return $response;
    }

    public function getUsersByEmail(string $email): array
    {
        return $this->getUsers([
            'email' => $email,
        ]);
    }

    /**
     * @param string $id
     * @param array  $parameters
     *
     * @return mixed
     */
    public function updateUser(string $id, array $parameters)
    {
        return $this->client->realm('PUT', '/users/'.$id, [], [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            'body' => json_encode($parameters),
        ]);
    }
}
