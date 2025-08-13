<?php
require('vendor/autoload.php');
use Razorpay\Api\Api;

$keyId = 'rzp_test_pi2fEEfhC66GKs';
$keySecret = 'jzWG8EKZkK9JEQMqjlCaWG7W';

$api = new Api($keyId, $keySecret);

$data = json_decode(file_get_contents("php://input"), true);

$paymentId = $data['razorpay_payment_id'];
$orderId = $data['razorpay_order_id'];
$signature = $data['razorpay_signature'];

try {
    $api->utility->verifyPaymentSignature([
        'razorpay_order_id' => $orderId,
        'razorpay_payment_id' => $paymentId,
        'razorpay_signature' => $signature
    ]);

    echo "Payment Verified Successfully!";
} catch (\Exception $e) {
    echo "Payment Verification Failed: " . $e->getMessage();
}
?>
