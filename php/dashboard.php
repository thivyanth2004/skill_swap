<?php
session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$conn = new mysqli('localhost', 'root', '', 'skill_swap');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add skill if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $skill_offered = $_POST['skill_offered'];
    $skill_wanted = $_POST['skill_wanted'];

    $sql = "INSERT INTO skills (user_id, skill_offered, skill_wanted) VALUES ('$user_id', '$skill_offered', '$skill_wanted')";
    if ($conn->query($sql) === TRUE) {
        $message = "Skill added successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}

// Retrieve user's skills
$sql = "SELECT skill_offered, skill_wanted FROM skills WHERE user_id = '$user_id'";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Dashboard</title>
</head>
<body>
    <div class="container">
        <h1>Dashboard</h1>
        <p>Welcome, User #<?php echo $user_id; ?>!</p>
        <a href="logout.php" style="color: red;">Logout</a>

        <!-- Display message -->
        <?php if (isset($message)) { ?>
            <p style="color: green;"><?php echo $message; ?></p>
        <?php } ?>

        <!-- Add Skill Form -->
        <form method="POST">
            <input type="text" name="skill_offered" placeholder="Skill You Offer" required>
            <input type="text" name="skill_wanted" placeholder="Skill You Want to Learn" required>
            <button type="submit">Add Skill</button>
        </form>

        <!-- Display User's Skills -->
        <h2>Your Skills</h2>
        <?php if ($result->num_rows > 0) { ?>
            <ul>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <li>
                        <strong>Offered:</strong> <?php echo htmlspecialchars($row['skill_offered']); ?>, 
                        <strong>Wanted:</strong> <?php echo htmlspecialchars($row['skill_wanted']); ?>
                    </li>
                <?php } ?>
            </ul>
        <?php } else { ?>
            <p>You haven't added any skills yet.</p>
        <?php } ?>

        <!-- Link to Skill Search -->
        <a href="search.php">Search for Skills</a>
    </div>
</body>
</html>
<?php $conn->close(); ?>
