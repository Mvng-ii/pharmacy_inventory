<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Patient') {
    header("Location: login.php");
    exit;
}
$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            text-align: center;
        }

        nav {
            background-color: #333;
            overflow: hidden;
        }

        nav a {
            color: white;
            padding: 14px 20px;
            text-decoration: none;
            display: inline-block;
        }

        nav a:hover {
            background-color: #ddd;
            color: black;
        }

        .container {
            padding: 20px;
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>

<header>
    <h1>Welcome, <?php echo $user['name']; ?> (Patient)</h1>
</header>

<nav>
    <a href="pages/view_prescriptions.php">View Prescriptions</a>
    <a href="pages/welcome.php">Logout</a>
</nav>

<div class="container">
    <h2>Your Patient Dashboard</h2>
    <p>As a patient, you can view your prescriptions and other personal details.</p>
</div>

<footer>
    <p>&copy; 2024 Neta Pharmacy. All rights reserved.</p>
</footer>

</body>
</html>
