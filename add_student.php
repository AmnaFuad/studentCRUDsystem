<?php
session_start();
include "db.php";
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['save'])) {
    $stmt = $conn->prepare("INSERT INTO students (full_name,email,course,enrollment_date) VALUES (?,?,?,?)");
    $stmt->bind_param("ssss", $_POST['name'], $_POST['email'], $_POST['course'], $_POST['date']);
    $stmt->execute();
    header("Location: students.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Student</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php include "navbar.php"; ?>

<div class="container mt-4">
<div class="card shadow p-4">
<h4 class="text-success">Add Student</h4>

<form method="POST">
<input class="form-control mb-2" name="name" placeholder="Full Name" required>
<input class="form-control mb-2" type="email" name="email" placeholder="Email" required>
<input class="form-control mb-2" name="course" placeholder="Course" required>
<input class="form-control mb-3" type="date" name="date" required>
<button class="btn btn-success" name="save">Save</button>
<a href="students.php" class="btn btn-secondary">Cancel</a>
</form>

</div>
</div>

</body>
</html>