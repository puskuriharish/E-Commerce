<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'vendor') {
    header("Location: ../login.php");
    exit();
}

include '../db.php';

$sql = "SELECT * FROM products WHERE vendor_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Products</title>
    <link rel="stylesheet" href="../styles.css"> 
    <style>
        /* Global Styling */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #ece9e6, #ffffff); /* Subtle gradient */
            margin: 0;
            padding: 0;
            color: #333;
        }

        /* Product List Styling */
        .product-list {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            padding: 40px;
            justify-content: center;
            max-height: calc(100vh - 100px);
            overflow-y: auto;
        }

        .product-list h2 {
            width: 100%;
            text-align: center;
            font-size: 2em;
            margin-bottom: 40px;
            color: #444;
            letter-spacing: 1.2px;
            font-weight: 600;
            text-transform: uppercase;
        }

        /* Individual Product Card */
        .product-item {
            background: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            padding: 25px;
            width: 23%; /* Four items in a row */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            animation: fadeIn 0.5s ease-in-out; /* Animation on load */
        }

        /* Hover Effect */
        .product-item:hover {
            transform: scale(1.03);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        /* Product Image First */
        .product-item img {
            max-width: 100%;
            height: 250px; /* Adjust image height */
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        /* Product Details Below Image */
        .product-item h3, .product-item p {
            text-align: center;
        }

        .product-item h3 {
            font-size: 1.5em;
            margin-bottom: 10px;
            color: #333;
        }

        .product-item p {
            font-size: 0.9em;
            color: #666;
            margin-bottom: 10px;
        }

        .product-item p.price {
            font-size: 1.2em;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 15px;
        }

        /* Action Links */
        .product-item a {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 10px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            font-size: 0.9em;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .product-item a:hover {
            background-color: #0056b3;
        }

        .product-item a.delete {
            background-color: #ff4d4d;
            margin-left: 10px;
        }

        .product-item a.delete:hover {
            background-color: #cc0000;
        }

        /* Media Queries for Responsiveness */
        @media (max-width: 1200px) {
            .product-item {
                width: 30%; /* Adjust for three items in a row on smaller screens */
            }
        }

        @media (max-width: 768px) {
            .product-item {
                width: 45%; /* Adjust for two items in a row on smaller screens */
            }

            .product-list {
                padding: 20px;
            }
        }

        @media (max-width: 480px) {
            .product-item {
                width: 100%; /* One item in a row on small mobile screens */
            }
        }

        /* Keyframe Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="product-list">
        <h2>Your Products</h2>
        <?php while ($product = $result->fetch_assoc()): ?>
            <div class="product-item">
                <!-- Product Image First -->
                <?php if (!empty($product['image_path'])): ?>
                    <img src="uploads/<?php echo htmlspecialchars($product['image_path']); ?>" alt="Product Image">
                <?php else: ?>
                    <p>No image available</p>
                <?php endif; ?>

                <!-- Product Details Below Image -->
                <h3><?php echo htmlspecialchars($product['product_name']); ?></h3>
                <p><?php echo htmlspecialchars($product['product_description']); ?></p>
                <p class="price">Price: $<?php echo htmlspecialchars($product['price']); ?></p>
                <p>Category: <?php echo htmlspecialchars($product['category']); ?></p>

                <!-- Action Buttons -->
                <a href="edit_product.php?id=<?php echo $product['product_id']; ?>">Edit</a>
                <a href="delete_product.php?id=<?php echo $product['product_id']; ?>" onclick="return confirm('Are you sure you want to delete this product?');" class="delete">Delete</a>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
