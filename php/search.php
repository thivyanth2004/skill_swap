<?php
session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'skill_swap');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Search functionality
$search_query = '';
if (isset($_POST['search'])) {
    $search_query = $_POST['search'];
    $sql = "SELECT skill_offered, skill_wanted, users.name FROM skills 
            JOIN users ON skills.user_id = users.id 
            WHERE skill_offered LIKE '%$search_query%' OR skill_wanted LIKE '%$search_query%'";
} else {
    $sql = "SELECT skill_offered, skill_wanted, users.name FROM skills 
            JOIN users ON skills.user_id = users.id";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Search Skills</title>
</head>
<body>
    <div class="container">
        <h1>Search Skills</h1>
        <a href="dashboard.php">Back to Dashboard</a>
        
        <!-- Search Form -->
        <form method="POST">
            <input type="text" name="search" placeholder="Search for skills" value="<?php echo htmlspecialchars($search_query); ?>" required>
            <button type="submit">Search</button>
        </form>

        <!-- Display Results -->
        <h2>Search Results</h2>
        <?php if ($result->num_rows > 0) { ?>
            <ul>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <li>
                        <strong>Offered Skill:</strong> <?php echo htmlspecialchars($row['skill_offered']); ?> <br>
                        <strong>Wanted Skill:</strong> <?php echo htmlspecialchars($row['skill_wanted']); ?> <br>
                        <strong>Offered by:</strong> <?php echo htmlspecialchars($row['name']); ?>
                    </li>
                <?php } ?>
            </ul>
        <?php } else { ?>
            <p>No skills found. Try searching with different keywords.</p>
        <?php } ?>

    </div>
</body>
</html>

<?php $conn->close(); ?>
