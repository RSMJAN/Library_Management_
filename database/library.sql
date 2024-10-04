-- Database: library

CREATE DATABASE IF NOT EXISTS library;
USE library;

-- Books table
CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    isbn VARCHAR(13) UNIQUE NOT NULL,
    copies_available INT NOT NULL
);

-- Members table
CREATE TABLE members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    membership_date DATE NOT NULL
);

-- Loans table
CREATE TABLE loans (
    id INT AUTO_INCREMENT PRIMARY KEY,
    book_id INT,
    member_id INT,
    loan_date DATE NOT NULL,
    return_date DATE,
    FOREIGN KEY (book_id) REFERENCES books(id),
    FOREIGN KEY (member_id) REFERENCES members(id)
);

-- Trigger to update book copies when a loan is created
DELIMITER //
CREATE TRIGGER loan_insert AFTER INSERT ON loans
FOR EACH ROW
BEGIN
    UPDATE books SET copies_available = copies_available - 1 WHERE id = NEW.book_id;
END //
DELIMITER ;

-- Stored procedure for returning books
DELIMITER //
CREATE PROCEDURE return_book(IN loanId INT)
BEGIN
    DECLARE bookId INT;
    SELECT book_id INTO bookId FROM loans WHERE id = loanId;
    UPDATE books SET copies_available = copies_available + 1 WHERE id = bookId;
    UPDATE loans SET return_date = NOW() WHERE id = loanId;
END //
DELIMITER ;
