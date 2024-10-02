<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'vendor') {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Menu</title>
    <link rel="stylesheet" href="../styles.css"> 
    <style>
        
        * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    /* Adding a gradient background */
    background: linear-gradient(135deg, #007bff, #00d4ff);
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;  /* Center the content vertically */
    height: 100vh;
}

/* Adding some padding around the main container for mobile view */
.vendor-menu {
    width: 100%;
    max-width: 800px;
    background-color: #fff;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);  /* Enhanced shadow for a floating effect */
    border-radius: 15px;  /* Smoother corners */
    text-align: center;
    margin: 20px;  /* Added margin for small screen breathing room */
    animation: fadeIn 1s ease-in-out; /* Add fade-in animation */
}

/* Subtle animation on page load */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

h2 {
    margin-bottom: 30px;
    font-size: 28px;
    color: #333;
    font-weight: 600;
}

/* Navigation list styling */
.vendor-menu ul {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
}

/* Spacing for buttons */
.vendor-menu li {
    margin: 10px;
}

/* Button styling */
.vendor-menu a {
    display: block;
    padding: 15px 25px;
    background-color: #007bff;
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-weight: bold;
    transition: background-color 0.3s ease, transform 0.3s ease; /* Smooth transitions */
    text-align: center;
    white-space: nowrap;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);  /* Button shadow */
}

/* Hover effects for buttons */
.vendor-menu a:hover {
    background-color: #0056b3;
    transform: translateY(-5px); /* Lift effect on hover */
}

/* Responsive layout adjustments */
@media (max-width: 600px) {
    .vendor-menu ul {
        flex-direction: column;
        align-items: stretch;
    }

    .vendor-menu li {
        margin: 10px 0;
    }
}

    </style>
</head>
<body>
    <div class="vendor-menu">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        <ul>
            <li><a href="view_product.php">View Products</a></li>
            <li><a href="add_product.php">Add Product</a></li>
            <li><a href="vendor_orders.php">Orders</a></li>
            <li><a href="../login.php">Logout</a></li>
        </ul>
    </div>
</body>
</html>
