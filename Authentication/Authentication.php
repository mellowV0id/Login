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
     * @return array
     */
    public function login(User $user): array
    {
        $whereUsername = [
            'username' => $user->getUsername(),
            'password' => $user->getPassword(),
            'balance'  => $this->getBalance()
        ];

        $user = $this->connection->select("users", [], $whereUsername)[0];

        if (!isset($user['username']) || !isset($user['password'])) {
            return [];
        }

        if ($user['password'] == $whereUsername['password']) {
            return $user;
        }

        $user->setBalance($this->getBalance());

        return [];
    }

    public function getBalance(): float
    {
        $username   = ['username' => $_POST['username']];
        $id         = $this->connection->select('users', ['id'], $username)[0];
        $whereKey   = ['id' => $id['id']];
        $balance    = ["balance" => '*'];
        $balance    = $this->connection->select('users', $balance, $whereKey)[0];

        return $balance['balance'];
    }
}
