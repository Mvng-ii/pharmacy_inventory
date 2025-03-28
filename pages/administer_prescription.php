<?php
session_start();
include '../db.php';

// Check if the user is logged in and has the correct role (Doctor or Superadmin)
if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['role'], ['Doctor', 'Superadmin'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];
$doctor_id = $user['id'];  // Doctor's ID from the session

// Fetch the doctor's name from the users table
$query = "SELECT name FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$stmt->bind_result($doctor_name);
$stmt->fetch();
$stmt->close();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $patient_id = $_POST['patient_id'];
    $medicine_id = $_POST['medicine_id'];
    $dosage = $_POST['dosage'];
    $notes = $_POST['notes'];
    $date_prescribed = $_POST['date_prescribed'];

    // Insert the prescription into the database, including the doctor's name
    $query = "INSERT INTO prescriptions (patient_id, medicine_id, dosage, notes, date_prescribed, doctor_id, doctor_name) 
              VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iisssis", $patient_id, $medicine_id, $dosage, $notes, $date_prescribed, $doctor_id, $doctor_name);
    $stmt->execute();

    // Redirect to the same page with a success message
    header("Location: administer_prescription.php?success=1");
    exit;
}

// Fetch all patients (only for doctors and superadmins to assign prescriptions)
$query = "SELECT id, name FROM users WHERE role = 'Patient'";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
$patients = $result->fetch_all(MYSQLI_ASSOC);

// Fetch all medicines from the medicines table
$query = "SELECT id, name FROM medicines";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
$medicines = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administer Prescription</title>
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

        form {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            max-width: 600px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-top: 10px;
            font-size: 14px;
        }

        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            margin-top: 15px;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
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

        .success {
            color: green;
            font-size: 16px;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<header>
    <h1>Administer Prescription</h1>
</header>

<nav>
    <a href="pages/doctorpage.php">Back to Dashboard</a>
    <a href="pages/welcome.php">Logout</a>
</nav>

<div class="container">
    <?php if (isset($_GET['success'])) : ?>
        <p class="success">Prescription administered successfully!</p>
    <?php endif; ?>

    <h2>Assign Prescription to a Patient</h2>
    <form method="POST">
        <label for="patient_id">Select Patient:</label>
        <select id="patient_id" name="patient_id" required>
            <option value="" disabled selected>Select a patient</option>
            <?php foreach ($patients as $patient) : ?>
                <option value="<?php echo $patient['id']; ?>"><?php echo $patient['name']; ?></option>
            <?php endforeach; ?>
        </select>

        <label for="medicine_id">Select Medicine:</label>
        <select id="medicine_id" name="medicine_id" required>
            <option value="" disabled selected>Select a medicine</option>
            <?php foreach ($medicines as $medicine) : ?>
                <option value="<?php echo $medicine['id']; ?>"><?php echo $medicine['name']; ?></option>
            <?php endforeach; ?>
        </select>

        <label for="dosage">Dosage:</label>
        <input type="text" id="dosage" name="dosage" required>

        <label for="notes">Notes:</label>
        <textarea id="notes" name="notes"></textarea>

        <label for="date_prescribed">Date Prescribed:</label>
        <input type="date" id="date_prescribed" name="date_prescribed" required>

        <button type="submit">Administer Prescription</button>
    </form>
</div>

</body>
</html>
