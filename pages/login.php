<?php
session_start();
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        
        // Redirect based on user role
        if ($user['role'] === 'Patient') {
            header("Location: patientpage.php");
        } elseif ($user['role'] === 'Doctor') {
            header("Location: adminpage.php");
        } elseif ($user['role'] === 'Superadmin') {
            header("Location: superadminpage.php");
        } else {
            // Default redirect in case of unknown role (optional)
            header("Location: index.php");
        }
        exit; // Make sure to stop the script execution after the redirect
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: url('../images/Medical.jpeg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            text-align: center;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            margin-top: 20px;
            max-width: 400px;
        }

        h1 {
            color: #333;
            margin: 0;
            padding: 10px 0;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-top: 10px;
            font-size: 14px;
            text-align: left;
        }

        input {
            margin-top: 5px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        button {
            margin-top: 15px;
            padding: 10px;
            background-color: blueviolet;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #6b3fa0;
        }

        .error {
            color: red;
            margin-top: 10px;
            font-size: 14px;
        }

        a {
            color: blueviolet;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
        </form>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <p>Don't have an account? <a href="pages/register.php">Register here</a>.</p>
    </div>
</body>
</html>
