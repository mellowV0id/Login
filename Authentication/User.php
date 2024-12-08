<?php

class User
{
    /**
     * @var string
     */
    private string $username;

    /**
     * @var string
     */
    private string $password;

    /**
     * @var float|int
     */
    private float $balance;

    public function __construct(string $username, string $password, float $balance = 0)
    {
        $this->username = $username;
        $this->password = $password;
        $this->balance  = $balance;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $username
     * @return void
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @param string $password
     * @return void
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function setBalance(float $balance): void
    {
        $this->balance = $balance;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }
}