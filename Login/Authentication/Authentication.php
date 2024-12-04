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
        $dispo         = $this->connection->select("users", [], $whereUsername);

        if (!isset($dispo['username']) || !isset($dispo['password'])) {
            echo "Wrong data!";
            return false;
        }
        if ($dispo['password'] == $user->getPassword()) {
            echo "Login successful";
            return true;
        }

        echo "Wrong username or password";
        return false;
    }
}