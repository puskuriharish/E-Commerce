<?php
session_start();
include '../db.php'; 

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'customer') {
    header("Location: ../login.php");
    exit();
}

if (!isset($_GET['order_id'])) {
    header("Location: ../customer/manage_cart.php");
    exit();
}

$order_id = $_GET['order_id'];
$user_id = $_SESSION['user_id'];


$sql = "SELECT total_amount FROM orders WHERE order_id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Invalid order.";
    exit();
}

$order = $result->fetch_assoc();
$total_amount = $order['total_amount'];

$sql = "SELECT product_id FROM cart WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$cart_items = $result->fetch_all(MYSQLI_ASSOC);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $payment_method = $_POST['payment_method'];
    
    foreach ($cart_items as $item) {
        $product_id = $item['product_id'];
        
    
        $stmt = $conn->prepare("INSERT INTO payments (order_id, user_id, product_id, amount_paid, payment_method, payment_date) VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("iiids", $order_id, $user_id, $product_id, $total_amount, $payment_method);
        $stmt->execute();
    }
    
    
    if ($payment_method === 'UPI') {
        $stmt = $conn->prepare("UPDATE orders SET status = 'Paid' WHERE order_id = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
    }
    
    
    echo "<script>alert('Payment successful!'); window.location.href = 'rating.php?order_id=" . $order_id . "';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" href="../styles.css"> 
    <style>

        .payment-form {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .payment-form h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .payment-form label {
            font-size: 1.1em;
            margin-bottom: 10px;
            display: block;
        }
        .payment-form select, .payment-form button {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            font-size: 1em;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .payment-form button {
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }
        .payment-form button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="payment-form">
        <h2>Payment</h2>
        <form method="POST" action="">
            <label for="payment_method">Select Payment Method</label>
            <select id="payment_method" name="payment_method" required>
                <option value="UPI">UPI</option>
                <option value="COD">Cash on Delivery (COD)</option>
            </select>
            <button type="submit">Pay $<?php echo number_format($total_amount, 2); ?></button>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
