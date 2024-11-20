<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Doctor') {
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
    <title>Doctor Dashboard</title>
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
    <h1>Welcome, Dr. <?php echo $user['name']; ?> (Doctor)</h1>
</header>

<nav>
    <a href="medicine_tracker.php">Medicine Tracker</a>
    <a href="administer_prescription.php">Administer Prescription</a>
    <a href="welcome.php">Logout</a>
</nav>

<div class="container">
    <h2>Your Doctor Dashboard</h2>
    <p>As a doctor, you can track medicines and administer prescriptions to patients.</p>
</div>

<footer>
    <p>&copy; 2024 Neta Pharmacy. All rights reserved.</p>
</footer>

</body>
</html>
