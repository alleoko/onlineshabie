<?php
// === AWS RDS DB CONFIG ===
$host = 'database-1.c38kuy62qmhp.ap-southeast-1.rds.amazonaws.com'; // Replace with your RDS endpoint
$db = 'database-1';                   // The DB name you created
$user = 'admin';                  // Your RDS master username
$pass = 'Billion.0513';                  // Your RDS master password

// === Connect to RDS MySQL ===
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// === Create Task ===
if (isset($_POST['submit'])) {
    $title = $conn->real_escape_string($_POST['title']);
    if (!empty($title)) {
        $conn->query("INSERT INTO tasks (title) VALUES ('$title')");
        header("Location: index.php"); // Refresh to show updated list
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Simple PHP + RDS CRUD</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            width: 500px;
            margin: 50px auto;
        }
        input[type="text"] {
            padding: 8px;
            width: 70%;
        }
        button {
            padding: 8px;
        }
        ul {
            padding: 0;
            list-style-type: none;
        }
        li {
            padding: 6px 0;
        }
    </style>
</head>
<body>

<h2>Add a Task</h2>
<form action="" method="POST">
    <input type="text" name="title" placeholder="Enter a task..." required>
    <button type="submit" name="submit">Add</button>
</form>

<h3>Task List</h3>
<ul>
    <?php
    $result = $conn->query("SELECT * FROM tasks ORDER BY id DESC");
    while ($row = $result->fetch_assoc()):
    ?>
        <li>• <?= htmlspecialchars($row['title']) ?></li>
    <?php endwhile; ?>
</ul>

</body>
</html>
