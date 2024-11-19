<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Register</title>
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $conn = new mysqli('localhost', 'root', '', 'skill_swap');

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
            if ($conn->query($sql) === TRUE) {
                echo "<p style='color:green;'>Registration successful!</p>";
            } else {
                echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
            }
            $conn->close();
        }
        ?>
        <form method="POST">
            <input type="text" name="name" placeholder="Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Register</button>
        </form>
        <a href="login.php">Already have an account? Login</a>
    </div>
</body>
</html>
