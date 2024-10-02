<?php
session_start();
include '../db.php'; 

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'customer') {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];


$sql = "SELECT c.cart_id, p.product_name, p.price, c.quantity FROM cart c 
        JOIN products p ON c.product_id = p.product_id WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$total_amount = 0;
$cart_items = [];

while ($row = $result->fetch_assoc()) {
    $total_price = $row['price'] * $row['quantity'];
    $total_amount += $total_price;
    $cart_items[] = $row + ['total_price' => $total_price];
}


$discount = $total_amount * 0.05; 
$delivery_charge = 40.00; 
$final_amount = $total_amount - $discount + $delivery_charge;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stmt = $conn->prepare("INSERT INTO orders (user_id, total_amount, order_date, status) VALUES (?, ?, NOW(), 'Pending')");
    $stmt->bind_param("id", $user_id, $final_amount);
    $stmt->execute();
    $order_id = $stmt->insert_id;

    
    header("Location: payment.php?order_id=" . $order_id);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Summary</title>
    <link rel="stylesheet" href="../styles.css"> 
    <style>
        

body {
    font-family: 'Poppins', sans-serif;
    background-color :antiquewhite;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    color: #333;
}

.order-summary {
    max-width: 700px;
    background: #fff;
    padding: 40px 50px;
    box-shadow: 0px 15px 30px rgba(0, 0, 0, 0.2);
    border-radius: 20px;
    transition: all 0.3s ease;
    border-top: 8px solid #ff6b6b;
    position: relative;
    overflow: hidden;
}

.order-summary:before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(to bottom right, #ff6b6b, #f8e71c);
    transform: rotate(45deg);
    opacity: 0.05;
    pointer-events: none;
}

.order-summary:hover {
    box-shadow: 0px 20px 40px rgba(0, 0, 0, 0.25);
    transform: translateY(-10px);
}

.order-summary h2 {
    text-align: center;
    color: #ff6b6b;
    margin-bottom: 25px;
    font-size: 2.2em;
    font-weight: 700;
}

.order-summary table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 30px;
    border-radius: 12px;
    overflow: hidden;
    background-color: #fafafa;
}

.order-summary th, td {
    padding: 16px;
    text-align: left;
    border-bottom: 1px solid #eee;
    color: #444;
    font-size: 1em;
}

.order-summary th {
    background-color: #f1f1f1;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.order-summary td {
    background-color: #ffffff;
}

.order-summary tr:last-child td {
    border-bottom: none;
}

.order-summary .summary, .order-summary .total {
    text-align: right;
    margin-bottom: 20px;
    font-size: 1.2em;
    color: #555;
}

.order-summary .total {
    font-size: 1.6em;
    font-weight: 700;
    color: #ff6b6b;
}

.order-summary button {
    display: block;
    width: 100%;
    padding: 15px;
    background-image: linear-gradient(to right, #ff6b6b, #f8e71c);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 1.2em;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.1);
}

.order-summary button:hover {
    background-image: linear-gradient(to right, #ff8a65, #ffd54f);
    box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.15);
    transform: translateY(-5px);
}

.order-summary button:active {
    background-image: linear-gradient(to right, #ff7043, #ffc107);
    transform: translateY(0);
}

    </style>
</head>
<body>
    <div class="order-summary">
        <h2>Order Summary</h2>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart_items as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                        <td>$<?php echo number_format($item['price'], 2); ?></td>
                        <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                        <td>$<?php echo number_format($item['total_price'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="summary">
            <strong>Subtotal: ₹<?php echo number_format($total_amount, 2); ?></strong><br>
            <strong>Discount (5%): -₹<?php echo number_format($discount, 2); ?></strong><br>
            <strong>Delivery Charge: ₹<?php echo number_format($delivery_charge, 2); ?></strong><br>
        </div>
        <div class="total">
            <strong>Final Amount: ₹<?php echo number_format($final_amount, 2); ?></strong>
        </div>
        <form method="POST" action="">
            <button type="submit">Place Order</button>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
