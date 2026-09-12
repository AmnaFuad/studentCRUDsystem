<?php
session_start();
include "db.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$id = (int) $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM students WHERE student_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();

if (!$row) {
    header("Location: students.php");
    exit();
}

if (isset($_POST['update'])) {
    $stmt = $conn->prepare("UPDATE students SET full_name=?, email=?, course=?, enrollment_date=? WHERE student_id=?");
    $stmt->bind_param("ssssi", $_POST['name'], $_POST['email'], $_POST['course'], $_POST['date'], $id);
    $stmt->execute();
    header("Location: students.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Student</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php include "navbar.php"; ?>

<div class="container mt-4">
<div class="card shadow p-4">
<h4 class="text-warning">Edit Student</h4>

<form method="POST">
<input class="form-control mb-2" name="name" value="<?= htmlspecialchars($row['full_name']) ?>" required>
<input class="form-control mb-2" name="email" value="<?= htmlspecialchars($row['email']) ?>" required>
<input class="form-control mb-2" name="course" value="<?= htmlspecialchars($row['course']) ?>" required>
<input class="form-control mb-3" type="date" name="date" value="<?= htmlspecialchars($row['enrollment_date']) ?>" required>
<button class="btn btn-warning" name="update">Update</button>
<a href="students.php" class="btn btn-secondary">Cancel</a>
</form>

</div>
</div>

</body>
</html>

