<?php


class ATM
{
    /**
     * @var Database
     */
    private Database $connection;

    public function __construct(Database $db)
    {
        $this->connection = $db;
    }

    public function updateGlobalBalance(): void
    {
        $_SESSION['current_balance'] = $this->getBalance();
    }
    /**
     * @return float
     */
    public function getBalance(): float
    {
        $whereKey   = ['id'      => $_SESSION['userid']];
        $balance    = ["balance" => '*'];
        $balance    = $this->connection->select('users', $balance, $whereKey)[0];

        return $balance['balance'];
    }

    /**
     * Withdraws the amount from the already existing balance
     * @param float $amount
     * @return void
     */
    public function withdraw(float $amount): void
    {
        $balance = $this->getBalance();
        $id      = $_SESSION['userid'];

        if ($amount > $balance)
        {
            die("Cant withdraw this amount.");
        }

        $balance   -= $amount;
        $balance   = ['balance' => $balance];
        $this->connection->update('users', $balance , "id = $id");
    }

    /**
     * Deposits the amount inside the already existing balance
     * @param float $amount
     * @return void
     */
    public function deposit(float $amount): void
    {
        $balance = $this->getBalance();
        $id      = $_SESSION['userid'];

        $balance   += $amount;
        $balance   = ['balance' => $balance];

        $this->connection->update('users', $balance , "id = $id");
    }

    /**
     * @param float $amount
     * @param string $userid
     * @return void
     */
    public function transfer(float $amount, string $userid): void
    {

        $whereKey   = ['id' => $userid];
        $balance    = ["balance" => '*'];
        $balance    = $this->connection->select('users', $balance, $whereKey)[0];

        $this->withdraw($amount);


        $balance['balance']   += $amount;

        $this->connection->update('users', $balance, "id = $userid");
        $balanceMessage = "Your new balance is : " . $balance['balance'];
        $depositMessage =  "You successfully deposited :" . $amount . PHP_EOL;
        echo $balanceMessage . PHP_EOL . $depositMessage . "to user: $userid" . PHP_EOL;
    }

}