<?php
session_start();
include '../db.php';

// Check if the user is logged in and has the correct role
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Superadmin') {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];

// Fetch all users from the database
$query = "SELECT id, name, email, role FROM users";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
$users = $result->fetch_all(MYSQLI_ASSOC);

// Update user role if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'], $_POST['role'])) {
    $user_id = $_POST['user_id'];
    $new_role = $_POST['role'];

    // Update the role of the selected user
    $update_query = "UPDATE users SET role = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("si", $new_role, $user_id);
    $update_stmt->execute();

    // Refresh the page after updating the role
    header("Location: user_management.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
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

        .role-select {
            width: 120px;
            padding: 5px;
        }

        .update-btn {
            background-color: #4CAF50;
            color: white;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
        }

        .update-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<header>
    <h1>User Management</h1>
</header>

<nav>
    <a href="pages/superadmin.php">Back to Dashboard</a>
    <a href="pages/welcome.php">Logout</a>
</nav>

<div class="container">
    <h2>Manage Users</h2>
    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Update Role</th>
        </tr>
        <?php foreach ($users as $user) : ?>
            <tr>
                <td><?php echo htmlspecialchars($user['name']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td><?php echo htmlspecialchars($user['role']); ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                        <select name="role" class="role-select">
                            <option value="Patient" <?php echo $user['role'] === 'Patient' ? 'selected' : ''; ?>>Patient</option>
                            <option value="Doctor" <?php echo $user['role'] === 'Doctor' ? 'selected' : ''; ?>>Doctor</option>
                            <option value="Superadmin" <?php echo $user['role'] === 'Superadmin' ? 'selected' : ''; ?>>Superadmin</option>
                        </select>
                        <button type="submit" class="update-btn">Update Role</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<footer>
    <p>&copy; 2024 Neta Pharmacy. All rights reserved.</p>
</footer>

</body>
</html>
