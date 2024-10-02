<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'customer') {
    header("Location: ../login.php");
    exit();
}

include '../db.php';


if (isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];

    $sql = "SELECT * FROM orders WHERE order_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $order_id, $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Order</title>
    <link rel="stylesheet" href="../styles.css"> 
    <style>
         body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
        }

        .track-order {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            font-size: 2em;
            margin-bottom: 20px;
            color: #333;
            text-transform: uppercase;
            letter-spacing: 1.2px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            align-items: center;
        }

        label {
            font-size: 1.2em;
            color: #555;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1em;
            box-sizing: border-box;
        }

        button {
            padding: 12px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 1.1em;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        h3 {
            font-size: 1.5em;
            margin-top: 30px;
            color: #333;
            text-align: center;
        }

        p {
            font-size: 1.1em;
            margin: 10px 0;
            color: #555;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            .track-order {
                margin: 20px;
                padding: 20px;
            }

            h2 {
                font-size: 1.8em;
            }

            h3 {
                font-size: 1.3em;
            }

            label, input, button, p {
                font-size: 1em;
            }
        }
    
    </style>
</head>
<body>
    <div class="track-order">
        <h2>Track Order</h2>
        <form method="post" action="">
            <label for="order_id">Enter Order ID:</label>
            <input type="text" id="order_id" name="order_id" required>
            <button type="submit">Track Order</button>
        </form>

        <?php if (isset($order)): ?>
            <h3>Order Details</h3>
            <p>Order ID: <?php echo htmlspecialchars($order['order_id']); ?></p>
            <p>Status: <?php echo htmlspecialchars($order['status']); ?></p>
            <p>Order Date: <?php echo htmlspecialchars($order['order_date']); ?></p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>
