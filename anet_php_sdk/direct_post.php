<?php
require_once 'AuthorizeNet.php'; // Make sure this path is correct.
$transaction = new AuthorizeNetAIM('84Bvg7Bt42ds', '3Z6Ea47eg2ED8ryR');
$transaction->amount = '9.994';
$transaction->card_num = '4007000000027';
$transaction->exp_date = '10/17';

$response = $transaction->authorizeAndCapture();


if ($response->approved) {
  echo "<h1>Success! The test credit card has been charged!</h1>";
  echo "Transaction ID: " . $response->transaction_id;
} else {
  echo $response->error_message.	$response->transaction_id;
}
?>