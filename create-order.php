<?php
require('vendor/autoload.php');
use Razorpay\Api\Api;

$keyId = 'rzp_test_pi2fEEfhC66GKs';
$keySecret = 'jzWG8EKZkK9JEQMqjlCaWG7W';

if (isset($_POST['amount'])) {
    $amount = (int) $_POST['amount'] * 100; // Convert to paise

    $api = new Api($keyId, $keySecret);
    $orderData = [
        'receipt'         => 'rcptid_' . time(),
        'amount'          => $amount,
        'currency'        => 'INR',
        'payment_capture' => 1
    ];

    $order = $api->order->create($orderData);

    echo json_encode([
        'orderId' => $order['id'],
        'amount'  => $amount,
        'keyId'   => $keyId
    ]);
}
?>
