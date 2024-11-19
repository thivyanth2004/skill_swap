<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $conn = new mysqli('localhost', 'root', '', 'skill_swap');

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM users WHERE email='$email'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                if (password_verify($password, $user['password'])) {
                    session_start();
                    $_SESSION['user_id'] = $user['id'];
                    header("Location: dashboard.php");
                } else {
                    echo "<p style='color:red;'>Invalid credentials!</p>";
                }
            } else {
                echo "<p style='color:red;'>No user found!</p>";
            }
            $conn->close();
        }
        ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <a href="registration.php">Don't have an account? Register</a>
    </div>
</body>
</html>
