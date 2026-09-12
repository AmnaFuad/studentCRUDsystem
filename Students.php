<?php
session_start();
include "db.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$search = "";
if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
}

if ($search !== "") {
    $like = "%$search%";
    $stmt = $conn->prepare(
        "SELECT * FROM students
         WHERE full_name LIKE ? OR email LIKE ? OR course LIKE ?"
    );
    $stmt->bind_param("sss", $like, $like, $like);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM students");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Students</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php include "navbar.php"; ?>

<div class="container mt-4">
<div class="card shadow">
<div class="card-header bg-success text-white">
<h4>Student List</h4>
</div>

<div class="card-body">

<!-- 🔍 SEARCH + LOAD ALL -->
<form method="GET" action="" class="row mb-3 g-2">
    <div class="col-md-7">
        <input type="text"
               name="search"
               class="form-control"
               placeholder="Enter search here..."
               value="<?= htmlspecialchars($search) ?>">
    </div>

    <div class="col-md-3">
        <button type="submit" class="btn btn-success w-100">
            🔍 Search
        </button>
    </div>

    <div class="col-md-2">
        <a href="students.php" class="btn btn-success mb-3">
            🔄 Load All
        </a>
    </div>
</form>

<a href="add_student.php" class="btn btn-success mb-3">➕ Add Student</a>

<table class="table table-hover table-bordered">
<thead class="table-dark">
<tr>
<th>Name</th><th>Email</th><th>Course</th><th>Date</th><th>Actions</th>
</tr>
</thead>

<tbody>
<?php if ($result->num_rows > 0): ?>
<?php while ($row = $result->fetch_assoc()) { ?>
<tr>
<td><?= htmlspecialchars($row['full_name']) ?></td>
<td><?= htmlspecialchars($row['email']) ?></td>
<td><?= htmlspecialchars($row['course']) ?></td>
<td><?= $row['enrollment_date'] ?></td>
<td>
<a class="btn btn-warning btn-sm" href="edit_student.php?id=<?= $row['student_id'] ?>">Edit</a>
<a class="btn btn-danger btn-sm" href="delete_student.php?id=<?= $row['student_id'] ?>"
   onclick="return confirm('Delete this record?')">Delete</a>
</td>
</tr>
<?php } ?>
<?php else: ?>
<tr>
<td colspan="5" class="text-center text-danger">
    No records found
</td>
</tr>
<?php endif; ?>
</tbody>

</table>
</div>
</div>
</div>

</body>
</html>
