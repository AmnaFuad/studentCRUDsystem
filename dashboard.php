<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Show success message if exists
if (isset($_SESSION['success'])) {
    $success = $_SESSION['success'];
    unset($_SESSION['success']); // remove it so it shows only once
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php include "navbar.php"; ?>

<div class="container mt-4">
    <?php if (isset($success)) { ?>
    <div class="alert alert-success text-center">
        <?= $success ?>
    </div>
    <?php } ?>
<div class="card shadow p-4 text-center">
<h3 class="text-primary">Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?> 👋</h3>
<p class="text-muted">Manage student records easily</p>
<a href="students.php" class="btn btn-success">Go to Student Management</a>
</div>
</div>

</body>
</html>
