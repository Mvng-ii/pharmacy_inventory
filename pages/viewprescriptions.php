<?php
session_start();
include '../db.php';

// Check if the user is logged in and has the correct role (Superadmin)
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Superadmin') {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];

// Query to fetch all prescriptions along with the doctor and patient names
$query = "
    SELECT p.id AS prescription_id, 
           m.name AS medicine_name, 
           p.dosage, 
           p.date_prescribed, 
           p.notes, 
           u.name AS patient_name, 
           d.name AS doctor_name
    FROM prescriptions p
    JOIN medicines m ON p.medicine_id = m.id
    JOIN users u ON p.patient_id = u.id
    JOIN users d ON p.doctor_id = d.id  -- Join on doctor_id
";

$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

// Fetch all prescriptions
if ($result->num_rows > 0) {
    $prescriptions = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $prescriptions = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Prescriptions</title>
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
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

        .no-prescriptions {
            color: #999;
            text-align: center;
            padding: 20px;
        }
    </style>
</head>
<body>

<header>
    <h1>View All Prescriptions</h1>
</header>

<nav>
    <a href="superadmin.php">Back to Dashboard</a>
    <a href="logout.php">Logout</a>
</nav>

<div class="container">
    <?php if (!empty($prescriptions)) : ?>
        <h2>All Prescriptions</h2>
        <table>
            <tr>
                <th>Prescription ID</th>
                <th>Medicine Name</th>
                <th>Dosage</th>
                <th>Date Prescribed</th>
                <th>Notes</th>
                <th>Patient</th>
                <th>Doctor</th>
            </tr>
            <?php foreach ($prescriptions as $prescription) : ?>
                <tr>
                    <td><?php echo $prescription['prescription_id']; ?></td>
                    <td><?php echo $prescription['medicine_name']; ?></td>
                    <td><?php echo $prescription['dosage']; ?></td>
                    <td><?php echo $prescription['date_prescribed']; ?></td>
                    <td><?php echo $prescription['notes']; ?></td>
                    <td><?php echo $prescription['patient_name']; ?></td>
                    <td><?php echo $prescription['doctor_name']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else : ?>
        <p class="no-prescriptions">No prescriptions available.</p>
    <?php endif; ?>
</div>

<!--<footer>
    <p>&copy; 2024 Neta Pharmacy. All rights reserved.</p>
</footer> -->

</body>
</html>
