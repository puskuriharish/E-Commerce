<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'customer') {
    header("Location: ../login.php");
    exit();
}

include '../db.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $rating = $_POST['rating'];
    $review = $_POST['review'];

    
    $sql = "INSERT INTO reviews (user_id, product_id, rating, review_text) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiis", $_SESSION['user_id'], $product_id, $rating, $review);

    if ($stmt->execute()) {
        $success = "Thank you for your review!";
    } else {
        $error = "Error: " . $stmt->error;
    }

    $stmt->close();
}

$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rate Products</title>
    <link rel="stylesheet" href="../styles.css"> 
    <style>
body {
    font-family: 'Poppins', sans-serif;
    background-color: #eef2f7;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.rating {
    max-width: 600px;
    width: 100%;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background-color: #ffffff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.rating h2 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
    font-size: 1.8rem;
    font-weight: bold;
}

.rating form {
    display: flex;
    flex-direction: column;
}

.rating label {
    margin-bottom: 8px;
    color: #555;
    font-weight: 500;
    font-size: 1rem;
}

.rating input[type="number"],
.rating textarea,
.rating select {
    padding: 12px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 1rem;
    color: #555;
    width: 100%;
}

.rating input[type="number"]:focus,
.rating textarea:focus,
.rating select:focus {
    border-color: #007bff;
    outline: none;
}

.rating button {
    padding: 12px;
    background-color: #007bff;
    color: #ffffff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1.1rem;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

.rating button:hover {
    background-color: #0056b3;
}


.success {
    color: #28a745;
    text-align: center;
    margin-bottom: 20px;
    font-size: 1.2rem;
}

.error {
    color: #dc3545;
    text-align: center;
    margin-bottom: 20px;
    font-size: 1.2rem;
}

@media (max-width: 768px) {
    .rating {
        padding: 15px;
    }

    .rating h2 {
        font-size: 1.5rem;
    }

    .rating input[type="number"],
    .rating textarea,
    .rating select {
        padding: 10px;
        font-size: 0.9rem;
    }

    .rating button {
        padding: 10px;
        font-size: 1rem;
    }
}

    </style>
</head>
<body>
    <div class="rating">
        <h2>Rate Products</h2>
        <?php if (isset($success)) { echo "<p class='success'>$success</p>"; } ?>
        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        <form method="post" action="">
            <label for="product_id">Select Product:</label>
            <select id="product_id" name="product_id" required>
                <?php while ($product = $result->fetch_assoc()): ?>
                    <option value="<?php echo $product['product_id']; ?>"><?php echo htmlspecialchars($product['product_name']); ?></option>
                <?php endwhile; ?>
            </select>

            <label for="rating">Rating (1-5):</label>
            <input type="number" id="rating" name="rating" min="1" max="5" required>

            <label for="review">Review:</label>
            <textarea id="review" name="review" rows="4" required></textarea>

            <button type="submit">Submit Review</button>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
