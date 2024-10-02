<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'vendor') {
    header("Location: ../login.php");
    exit();
}

include '../db.php';

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
        $product_description = mysqli_real_escape_string($conn, $_POST['product_description']);
        $price = mysqli_real_escape_string($conn, $_POST['price']);
        $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
        $category = mysqli_real_escape_string($conn, $_POST['category']);
        $image_path = $_POST['current_image'];

        
        if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        
            $check = getimagesize($_FILES["product_image"]["tmp_name"]);
            if ($check === false) {
                $uploadOk = 0;
                $error = "File is not an image.";
            }

        
            if ($_FILES["product_image"]["size"] > 500000) {
                $uploadOk = 0;
                $error = "Sorry, your file is too large.";
            }

        
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                $uploadOk = 0;
                $error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            }

            if ($uploadOk == 0) {
                $error = "Sorry, your file was not uploaded.";
            } else {
                if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
                    $image_path = htmlspecialchars(basename($_FILES["product_image"]["name"]));
                } else {
                    $error = "Sorry, there was an error uploading your file.";
                }
            }
        }

    
        if (!isset($error)) {
            $sql = "UPDATE products 
                    SET product_name = ?, product_description = ?, price = ?, quantity = ?, category = ?, image_path = ? 
                    WHERE product_id = ? AND vendor_id = ?";
            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("ssdisiis", $product_name, $product_description, $price, $quantity, $category, $image_path, $product_id, $_SESSION['user_id']);
                if ($stmt->execute()) {
                    $success = "Product updated successfully!";
                } else {
                    $error = "Error: " . $stmt->error;
                }
                $stmt->close();
            } else {
                $error = "Error preparing statement: " . $conn->error;
            }
        }
    }

   
    $sql = "SELECT * FROM products WHERE product_id = ? AND vendor_id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ii", $product_id, $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        $stmt->close();

        if (!$product) {
            die("Product not found.");
        }
    } else {
        die("Error preparing statement: " . $conn->error);
    }
} else {
    die("Invalid product ID.");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="../styles.css">
    <style>
        
body {
    font-family: 'Arial', sans-serif;
    background-color: #e9ecef;
    margin: 0;
    padding: 0;
}


.container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    padding: 20px;
}

.product-form-container {
    max-width: 1200px;
    width: 100%;
    margin: 0 auto;
    padding: 20px;
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transform: scale(0.9); 
}


.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}


.form-column {
    display: flex;
    flex-direction: column;
}


.product-form-container h2 {
    margin-bottom: 20px;
    font-size: 28px;
    color: #343a40;
}


.product-form-container label {
    display: block;
    margin: 12px 0 6px;
    font-weight: bold;
    color: #495057;
}


.product-form-container input[type="text"],
.product-form-container input[type="number"],
.product-form-container textarea,
.product-form-container input[type="file"] {
    width: 100%;
    padding: 12px;
    margin: 5px 0 20px;
    border: 1px solid #ced4da;
    border-radius: 8px;
    box-sizing: border-box;
    font-size: 16px;
}


.product-form-container textarea {
    height: 120px;
    resize: vertical;
}


.image-preview img {
    max-width: 100%;
    height: auto;
    border: 1px solid #ced4da;
    border-radius: 8px;
    margin-top: 20px;
}


.product-form-container button {
    background-color: #28a745;
    color: #ffffff;
    border: none;
    padding: 12px 24px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 18px;
    transition: background-color 0.3s ease, transform 0.3s ease;
}


.product-form-container button:hover {
    background-color: #218838;
    transform: scale(1.02);
}


.success {
    color: #28a745;
    margin-bottom: 20px;
    font-size: 18px;
}

.error {
    color: #dc3545;
    margin-bottom: 20px;
    font-size: 18px;
}

    </style>
</head>
<body>
    <div class="container">
        <div class="product-form-container">
            <form method="post" action="" enctype="multipart/form-data">
                <div class="form-grid">
                    <div class="form-column">
                        <h2>Edit Product</h2>
                        <?php if (isset($success)) { echo "<p class='success'>$success</p>"; } ?>
                        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>

                        <label for="product_name">Product Name:</label>
                        <input type="text" id="product_name" name="product_name" value="<?php echo htmlspecialchars($product['product_name']); ?>" required>
                        
                        <label for="product_description">Description:</label>
                        <textarea id="product_description" name="product_description" required><?php echo htmlspecialchars($product['product_description']); ?></textarea>
                        
                        <label for="price">Price:</label>
                        <input type="number" id="price" name="price" step="0.01" value="<?php echo htmlspecialchars($product['price']); ?>" required>
                        
                        <label for="quantity">Quantity:</label>
                        <input type="number" id="quantity" name="quantity" value="<?php echo htmlspecialchars($product['quantity']); ?>" required>
                    </div>

                    <div class="form-column">
                        <label for="category">Category:</label>
                        <input type="text" id="category" name="category" value="<?php echo htmlspecialchars($product['category']); ?>" required>
                        
                        <label for="product_image">Product Image (optional):</label>
                        <input type="file" id="product_image" name="product_image" accept="image/*">
                        <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($product['image_path']); ?>">
                        
                        <?php if (!empty($product['image_path'])): ?>
                            <div class="image-preview">
                                <img src="uploads/<?php echo htmlspecialchars($product['image_path']); ?>" alt="Current Product Image">
                            </div>
                        <?php endif; ?>
                        
                        <button type="submit">Update Product</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
