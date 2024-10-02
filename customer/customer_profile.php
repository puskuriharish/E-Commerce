<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'customer') {
    header("Location: ../login.php");
    exit();
}

include '../db.php';


$sql = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$customer = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $sql = "UPDATE users SET first_name = ?, last_name = ?, email = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $first_name, $last_name, $email, $_SESSION['user_id']);
    
    if ($stmt->execute()) {
        $success = "Profile updated successfully!";
    } else {
        $error = "Error: " . $stmt->error;
    }
    
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Profile</title>
    <link rel="stylesheet" href="../styles.css"> 
    <style>
         body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f3f4f6;
            margin: 0;
            padding: 0;
            color: #333;
        }

        /* Profile Container */
        .profile {
            max-width: 500px;
            margin: 50px auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .profile h2 {
            margin-bottom: 20px;
            font-size: 2em;
            color: #333;
            letter-spacing: 1.2px;
            text-transform: uppercase;
        }

        /* Success and Error Messages */
        .success, .error {
            font-size: 1em;
            margin: 15px 0;
            padding: 10px;
            border-radius: 8px;
            color: #fff;
        }

        .success {
            background-color: #4caf50; /* Green background for success */
        }

        .error {
            background-color: #e74c3c; /* Red background for error */
        }

        /* Form Styles */
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            font-size: 1.1em;
            margin-bottom: 8px;
            color: #444;
            align-self: flex-start;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1em;
            transition: border-color 0.3s ease;
        }

        input:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        button {
            padding: 12px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1.1em;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Media Queries for Responsive Design */
        @media (max-width: 600px) {
            .profile {
                padding: 20px;
                margin: 20px;
            }

            h2 {
                font-size: 1.8em;
            }

            label {
                font-size: 1em;
            }

            input {
                font-size: 0.9em;
            }

            button {
                font-size: 1em;
            }
        }
    </style>
</head>
<body>
    <div class="profile">
        <h2>Customer Profile</h2>
        <?php if (isset($success)) { echo "<p class='success'>$success</p>"; } ?>
        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        <form method="post" action="">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($customer['first_name']); ?>" required>
            
            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($customer['last_name']); ?>" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($customer['email']); ?>" required>
            
            <button type="submit">Update Profile</button>
        </form>
    </div>
</body>
</html>
