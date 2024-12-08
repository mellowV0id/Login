<?php
  session_start();

  $currentBalance = 'UNKNOWN';
  if (isset($_SESSION['current_balance'])) {
      $currentBalance = $_SESSION['current_balance'];
  }
?>

<!DOCTYPE html>
<html lang="">

<head>
    <title>Welcome</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="main">
    <h1>Welcome user, your balance is: $<?=$currentBalance?></h1>
    <form action="ATM/atmMain.php" method="POST">

        <input type="radio" id="deposit" name="operation" value="deposit">
        <label for ="deposit">DEPOSIT</label><br>

        <input type="radio" id="withdraw" name="operation" value="withdraw">
        <label for ="withdraw">WITHDRAW</label><br>

        <input type="radio" id="transfer" name="operation" value="transfer">
        <label for ="transfer">TRANSFER TO:</label>

        <label for="transferMoney">User Id</label>
        <input type="text" id="transferMoney" name="transferMoney">
        <label for="transfer">AMOUNT</label>

        <label for="amount"></label>
        <input type="text" id="amount" name="amount">

        <button>
            Submit operation
        </button>

    </form>
</div>

</body>

</html>
