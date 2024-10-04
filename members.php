<?php
$conn = new mysqli('localhost', 'root', '', 'library');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $membership_date = $_POST['membership_date'];

    $stmt = $conn->prepare("INSERT INTO members (name, email, membership_date) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $membership_date);
    $stmt->execute();
}

$result = $conn->query("SELECT * FROM members");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Members</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Manage Members</h1>
    </header>
    <div class="container">
        <h2>Add New Member</h2>
        <form method="POST">
            <input type="text" name="name" placeholder="Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="date" name="membership_date" required>
            <button type="submit">Add Member</button>
        </form>

        <h2>All Members</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Membership Date</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['membership_date']; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
