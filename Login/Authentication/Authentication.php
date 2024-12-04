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
    public function login(User $user): bool
    {
        $whereUsername = 'username = "' . $user->getUsername() . '"';
        $user          = $this->connection->select("users", [], $whereUsername);

        if (!isset($user['username']) || !isset($user['password'])) {
            return false;
        }

        if ($user['password'] == $user->getPassword()) {
            return true;
        }
        
        return false;
    }
}