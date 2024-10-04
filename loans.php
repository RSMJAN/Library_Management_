<?php
$conn = new mysqli('localhost', 'root', '', 'library');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $book_id = $_POST['book_id'];
    $member_id = $_POST['member_id'];
    $loan_date = $_POST['loan_date'];

    $stmt = $conn->prepare("INSERT INTO loans (book_id, member_id, loan_date) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $book_id, $member_id, $loan_date);
    $
