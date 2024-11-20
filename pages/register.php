<?php
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $name, $email, $password);

    if ($stmt->execute()) {
        header("Location: login.php");
    } else {
        $error = "Failed to register. Try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
            background-color: #ffffff; /* Background color for the rounded box */
            padding: 20px;
            border-radius: 10px; /* Rounded corners for the box */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); /* Box shadow for depth */
            margin-top: 20px; /* Adjust the top margin as needed */
            max-width: 400px; /* Limit the width of the container */
        }

        h1 {
            color: #333; /* Text color for the heading */
            margin: 0; /* Remove margin to ensure it's at the top */
            padding: 10px 0; /* Add padding for spacing */
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
            background-color: #6b3fa0; /* Darker shade on hover */
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
        <h1>Register</h1>
        <form method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Register</button>
        </form>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </div>
</body>
</html>
