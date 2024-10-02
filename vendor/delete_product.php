<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'vendor') {
    header("Location: ../login.php");
    exit();
}

include '../db.php';

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];


    $conn->begin_transaction();

    try {
      
        $sql_cart = "DELETE FROM cart WHERE product_id = ?";
        $stmt_cart = $conn->prepare($sql_cart);
        $stmt_cart->bind_param("i", $product_id);
        $stmt_cart->execute();
        $stmt_cart->close();

        
        $sql_product = "DELETE FROM products WHERE product_id = ? AND vendor_id = ?";
        $stmt_product = $conn->prepare($sql_product);
        $stmt_product->bind_param("ii", $product_id, $_SESSION['user_id']);
        $stmt_product->execute();
        $stmt_product->close();

   
        $conn->commit();

        $success = "Product deleted successfully!";
    } catch (Exception $e) {
       
        $conn->rollback();
        $error = "Error: " . $e->getMessage();
    }

    $conn->close();

    
    header("Location: view_product.php");
    exit();
} else {
    die("Invalid product ID.");
}
