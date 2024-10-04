<?php
$conn = new mysqli('localhost', 'root', '', 'library');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $loan_id = $_POST['loan_id'];

    // Call the stored procedure to return the book
    $stmt = $conn->prepare("CALL return_book(?)");
    $stmt->bind_param("i", $loan_id);
    $stmt->execute();
}

// Fetch all loans where the return date is NULL (i.e., the book is still on loan)
$result = $conn->query("SELECT loans.id, books.title, members.name, loans.loan_date
                        FROM loans
                        JOIN books ON loans.book_id = books.id
                        JOIN members ON loans.member_id = members.id
                        WHERE loans.return_date IS NULL");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Returns</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Manage Returns</h1>
    </header>
    <div class="container">
        <h2>Return a Book</h2>
        <form method="POST">
            <label for="loan_id">Select Loan:</label>
            <select name="loan_id" id="loan_id" required>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <option value="<?php echo $row['id']; ?>">
                        <?php echo $row['title'] . " (Loaned to " . $row['name'] . " on " . $row['loan_date'] . ")"; ?>
                    </option>
                <?php } ?>
            </select>
            <button type="submit">Return Book</button>
        </form>
    </div>
</body>
</html>
