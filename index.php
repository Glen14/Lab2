<?php
session_start(); 

require_once 'Book.php';

if (!isset($_SESSION['books'])) {
    $_SESSION['books'] = [];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $year = $_POST['year'];

    try {
        if ($title && $author && $year) {
            $book = new Book($title, $author, $year);
            $_SESSION['books'][] = $book;
        } else {
            throw new Exception("Please input all fields");
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

function displayBooks($books) {
    if (count($books) > 0) {
        echo "<h3>Book List:</h3>";
        echo "<table border='1'>";
        echo "<tr><th>Title</th><th>Author</th><th>Year</th></tr>";
        foreach ($books as $book) {
            echo "<tr>";
            echo "<td>" . $book->getTitle() . "</td>";
            echo "<td>" . $book->getAuthor() . "</td>";
            echo "<td>" . $book->getYear() . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No books added yet.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Management System</title>
</head>
<body>

<h1>Book Management System By Glen Correia n01615526</h1>

<form method="POST" action="index.php">
    <label for="title">Title:</label>
    <input type="text" id="title" name="title" required><br><br>
    
    <label for="author">Author:</label>
    <input type="text" id="author" name="author" required><br><br>
    
    <label for="year">Publication Year:</label>
    <input type="number" id="year" name="year" required><br><br>
    
    <input type="submit" value="Add Book">
</form>

<hr>

<?php
displayBooks($_SESSION['books']);
?>

</body>
</html>
