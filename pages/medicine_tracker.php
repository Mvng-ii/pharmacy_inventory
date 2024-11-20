<?php
session_start();
include '../db.php';

// Check if the user is logged in and has the correct role (Doctor, Superadmin or Admin)
if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['role'], ['Superadmin', 'Doctor'])) {
    header("Location: login.php");
    exit;
}

// Handling Add Medicine
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_medicine'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $expiration_date = $_POST['expiration_date'];
    $batch_number = $_POST['batch_number'];
    $picture_url = $_POST['picture_url'];

    // Insert the new medicine into the database
    $query = "INSERT INTO medicines (name, description, quantity, expiration_date, batch_number, picture_url) 
              VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssisbs", $name, $description, $quantity, $expiration_date, $batch_number, $picture_url);
    $stmt->execute();

    // Redirect to the same page after adding the medicine
    header("Location: medicine_tracker.php?added=1");
    exit;
}

// Handling Edit Medicine
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_medicine'])) {
    $medicine_id = $_POST['medicine_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $expiration_date = $_POST['expiration_date'];
    $batch_number = $_POST['batch_number'];
    $picture_url = $_POST['picture_url'];

    // Update the medicine details in the database
    $query = "UPDATE medicines SET name = ?, description = ?, quantity = ?, expiration_date = ?, batch_number = ?, picture_url = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssisbs", $name, $description, $quantity, $expiration_date, $batch_number, $picture_url, $medicine_id);
    $stmt->execute();

    // Redirect to the same page after editing the medicine
    header("Location: medicine_tracker.php?edited=1");
    exit;
}

// Handling Delete Medicine
if (isset($_GET['delete'])) {
    $medicine_id = $_GET['delete'];

    // Delete the medicine from the database
    $query = "DELETE FROM medicines WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $medicine_id);
    $stmt->execute();

    // Redirect to the same page after deleting the medicine
    header("Location: medicine_tracker.php?deleted=1");
    exit;
}

// Fetch all medicines from the medicines table
$query = "SELECT * FROM medicines";
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
    <title>Medicine Tracker</title>
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

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
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

        .error {
            color: red;
            font-size: 16px;
            text-align: center;
            margin-top: 20px;
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

        input, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<header>
    <h1>Medicine Tracker</h1>
</header>

<nav>
    <a href="admin_dashboard.php">Back to Dashboard</a>
    <a href="welcome.php">Logout</a>
</nav>

<div class="container">
    <?php if (isset($_GET['added'])) : ?>
        <p class="success">Medicine added successfully!</p>
    <?php elseif (isset($_GET['edited'])) : ?>
        <p class="success">Medicine updated successfully!</p>
    <?php elseif (isset($_GET['deleted'])) : ?>
        <p class="success">Medicine deleted successfully!</p>
    <?php endif; ?>

    <h2>All Medicines</h2>
    <table>
        <thead>
            <tr>
                <th>Medicine Name</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Expiration Date</th>
                <th>Batch Number</th>
                <th>Picture</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($medicines as $medicine) : ?>
                <tr>
                    <td><?php echo $medicine['name']; ?></td>
                    <td><?php echo $medicine['description']; ?></td>
                    <td><?php echo $medicine['quantity']; ?></td>
                    <td><?php echo $medicine['expiration_date']; ?></td>
                    <td><?php echo $medicine['batch_number']; ?></td>
                    <td><img src="<?php echo $medicine['picture_url']; ?>" alt="Medicine Image" width="50"></td>
                    <td>
                        <a href="edit_medicine.php?id=<?php echo $medicine['id']; ?>"><button>Edit</button></a>
                        <a href="?delete=<?php echo $medicine['id']; ?>" onclick="return confirm('Are you sure you want to delete this medicine?');"><button>Delete</button></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Add New Medicine</h2>
    <form method="POST" enctype="multipart/form-data">
        <label for="name">Medicine Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description"></textarea>

        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" required>

        <label for="expiration_date">Expiration Date:</label>
        <input type="date" id="expiration_date" name="expiration_date" required>

        <label for="batch_number">Batch Number:</label>
        <input type="text" id="batch_number" name="batch_number">

        <label for="picture_url">Picture:</label>
        <input type="file" id="picture_url" name="picture_url" accept="image/*">

        <button type="submit" name="add_medicine">Add Medicine</button>
    </form>
</div>

<!--<footer>
    <p>&copy; 2024 Neta Pharmacy. All rights reserved.</p>
</footer> -->

</body>
</html>