<?php include 'sidebar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
</head>
<body>
    <p>Enter the amount to pay</p>
    <input type="number" id="amount" placeholder="Enter amount" min="1">
    <button id="payBtn">Pay Now</button>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
    $("#payBtn").click(function(e) {
        e.preventDefault();

        let amount = $("#amount").val();
        if (!amount || amount <= 0) {
            alert("Please enter a valid amount");
            return;
        }

        // Create order dynamically
        $.post("create-order.php", { amount: amount }, function(data) {
            let orderData = JSON.parse(data);

            var options = {
                "key": orderData.keyId,
                "amount": orderData.amount,
                "currency": "INR",
                "name": "Test Payment",
                "description": "Dynamic Amount Payment",
                "order_id": orderData.orderId,
                "handler": function (response){
                    fetch("payment-success.php", {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify(response)
                    }).then(res => res.text())
                      .then(data => alert(data));
                },
                "theme": { "color": "#3399cc" }
            };
            var rzp1 = new Razorpay(options);
            rzp1.open();
        });
    });
    </script>
</body>
</html>
