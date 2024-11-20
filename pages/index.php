<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: pages/login.php");
}
$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pharmacy Inventory</title>
</head>
<body>
    <h2>Welcome, <?php echo $user['name']; ?></h2>
    <nav>
        <?php if ($user['role'] !== 'Patient') : ?>
            <a href="pages/medicine_tracker.php">Medicine Tracker</a>
            <a href="pages/view_prescriptions.php">View Prescriptions</a>
        <?php endif; ?>
        <?php if ($user['role'] === 'Nurse || Doctor') : ?>
            <a href="pages/administer_prescription.php">Administer Prescription</a>
        <?php endif; ?>
        <?php if ($user['role'] === 'Superadmin') : ?>
            <a href="pages/user_management.php">User Management</a>
        <?php endif; ?>
        <a href="scripts/logout.php">Logout</a>
    </nav>
</body>
</html>
