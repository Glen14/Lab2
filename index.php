<?php
spl_autoload_register(function ($class_name) {
    $file = $class_name . '.php';
    if (file_exists($file)) {
        include $file;
    }
});

$books = [];

if (isset($_COOKIE['books'])) {
    $books = unserialize($_COOKIE['books']);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $year = $_POST['year'];

    try {
        if ($title && $author && $year) {
            if (!class_exists('Book')) {
                throw new Exception("Book class not found.");
            }
            $book = new Book($title, $author, $year);
            $books[] = $book;
            setcookie('books', serialize($books), time() + 3600);
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
            if ($book instanceof Book) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($book->getTitle()) . "</td>";
                echo "<td>" . htmlspecialchars($book->getAuthor()) . "</td>";
                echo "<td>" . htmlspecialchars($book->getYear()) . "</td>";
                echo "</tr>";
            }
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
displayBooks($books);
?>

</body>
</html>
