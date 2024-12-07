<?php

class Authentication
{

    /**
     * @var Database
     */
    private Database $connection;

    /**
     * Only works with an already present connection as parameter
     * @param Database $db
     */
    public function __construct(Database $db)
    {
        $this->connection = $db;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function login(User $user): int
    {
        $whereUsername = [
            'username' => $user->getUsername(),
            'password' => $user->getPassword(),
        ];

        $user = $this->connection->select("users", [], $whereUsername)[0];

        if (!isset($user['username']) || !isset($user['password'])) {
            return 0;
        }

        if ($user['password'] == $whereUsername['password']) {
            return $user['id'];
        }
        
        return 0;
    }
}