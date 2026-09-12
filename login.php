<?php
session_start();
include "db.php"; // Database connection

// ===== Login =====
if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT user_id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify hashed password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user['username'];
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['success'] = "Successfully Logged In!!!";

            header("Location: dashboard.php");
            exit();
        }
    }

    $login_error = "Invalid username or password";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #ffffff;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            background: rgba(40, 167, 69, 0.2);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 30px;
            width: 350px;
            min-height: 350px;
            box-shadow: 0 8px 32px 0 rgba(0,0,0,0.25);
            border: 1px solid rgba(40, 167, 69, 0.3);
        }

        .card h3 {
            color: #28a745;
            text-align: center;
            font-weight: bold;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
        }

        .form-control {
            background: rgba(255,255,255,0.3);
            border: none;
            color: #000;
        }

        .form-control::placeholder {
            color: #555;
        }

        .form-control:focus {
            background: rgba(255,255,255,0.4);
            color: #000;
            box-shadow: none;
        }

        .btn-login {
            background: #28a745;
            border: none;
            font-weight: bold;
        }

        .btn-login:hover {
            background: #218838;
        }

        .alert {
            background: rgba(255,0,0,0.2);
            color: #ff0000;
            border: none;
            text-align: center;
        }

        .success {
            background: rgba(0,255,0,0.2);
            color: #28a745;
            border: none;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="card">
    <h3>Login</h3><br>

    <?php 
    if (isset($login_error)) echo "<div class='alert alert-danger'>$login_error</div>";
    if (isset($_SESSION['success'])) {
        echo "<div class='success'>" . $_SESSION['success'] . "</div>";
        unset($_SESSION['success']);
    }
    ?>

    <!-- Login Form -->
    <form method="POST" autocomplete="off" id="loginForm">
        <input class="form-control mb-3" name="username" placeholder="Username" required autocomplete="off">
        <input class="form-control mb-3" type="password" name="password" placeholder="Password" required autocomplete="new-password">
        <button class="btn btn-login w-100" name="login">Login</button>
    </form>
</div>

<script>
    // Clear input fields on page load to prevent browser autofill
    window.addEventListener('load', function() {
        const form = document.getElementById('loginForm');
        form.username.value = '';
        form.password.value = '';
    });
</script>

</body>
</html>
