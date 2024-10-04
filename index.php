<?php
// Connect to database
$conn = new mysqli('localhost', 'root', '', 'library');

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Library Management System</h1>
    </header>
    <div class="container">
        <h2>Welcome to the Library</h2>
        <p><a href="books.php">Manage Books</a></p>
        <p><a href="members.php">Manage Members</a></p>
        <p><a href="loans.php">Manage Loans</a></p>
        <p><a href="returns.php">Manage Returns</a></p>
    </div>
</body>
</html>
