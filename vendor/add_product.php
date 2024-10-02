<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'vendor') {
    header("Location: ../login.php");
    exit();
}

include '../db.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $vendor_id = $_SESSION['user_id'];
    $product_name = isset($_POST['product_name']) ? trim($_POST['product_name']) : '';
    $product_description = isset($_POST['product_description']) ? trim($_POST['product_description']) : '';
    $price = isset($_POST['price']) ? trim($_POST['price']) : '';
    $category = isset($_POST['category']) ? trim($_POST['category']) : '';
    $image_path = isset($_FILES['image']['name']) ? $_FILES['image']['name'] : '';

    
    if (!empty($product_name) && !empty($product_description) && !empty($price) && !empty($category) && !empty($image_path)) {
   
        $target_dir = "../customer/uploads/";
        $target_file = $target_dir . basename($image_path);
        
       
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            
            $sql = "INSERT INTO products (vendor_id, product_name, product_description, price, category, image_path) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            
            if ($stmt = $conn->prepare($sql)) {
                
                $stmt->bind_param('issdss', $vendor_id, $product_name, $product_description, $price, $category, $image_path);
                
             
                if ($stmt->execute()) {
                    echo "Product added successfully.";
                } else {
                    echo "Error executing query: " . $stmt->error;
                }
                
              
                $stmt->close();
            } else {
                echo "Error preparing statement: " . $conn->error;
            }
        } else {
            echo "Error uploading file. Please check the file and try again.";
        }
    } else {
        echo "Please fill in all required fields and upload an image.";
    }
} else {
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="../styles.css">
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

form {
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
    width: 400px;
}

h1 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
}

label {
    font-weight: bold;
    color: #333;
    display: block;
    margin-bottom: 5px;
}

input[type="text"],
textarea,
input[type="file"] {
    width: calc(100% - 20px);
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 5px;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

input[type="file"] {
    padding: 3px;
}

textarea {
    resize: none;
    height: 100px;
}

input[type="submit"] {
    width: 100%;
    padding: 10px;
    background-color: #4CAF50;
    border: none;
    border-radius: 5px;
    color: #fff;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

input[type="submit"]:hover {
    background-color: #45a049;
}


    </style>
</head>
<body>
    <form action="add_product.php" method="POST" enctype="multipart/form-data">
        <label for="product_name">Product Name:</label>
        <input type="text" name="product_name" id="product_name" required>
        
        <label for="product_description">Product Description:</label>
        <textarea name="product_description" id="product_description" required></textarea>
        
        <label for="price">Price:</label>
        <input type="text" name="price" id="price" required>
        
        <label for="category">Category:</label>
        <input type="text" name="category" id="category" required>
        
        <label for="image">Image:</label>
        <input type="file" name="image" id="image" required>
        
        <input type="submit" value="Add Product">
    </form>
</body>
</html>
<?php
}

$conn->close();
?>
