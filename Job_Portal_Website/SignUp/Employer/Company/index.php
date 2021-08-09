<?php require_once '../database.php';
//Update this for the new Database Attributes
if(isset($_POST["name"]) && isset($_POST["Author"])){
    $book = $conn->prepare("INSERT INTO Bookstore.books (name, Author)
    VALUES (:name,:Author);");
    $book->bindParam(':name', $_POST["name"]);
    $book->bindParam(':Author', $_POST["Author"]);

    if($book->execute()){
        header("Location: .");
    }
}   

$statement = $conn->prepare('SELECT * FROM Bookstore.books AS books');
$statement->execute();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Sign Up</title>
</head>
<body>
<h1>Sign Up</h1>
<!-- Update the Form to match the database -->
    <form action="./create.php" method="post">
        <label for="name">Title</label><br>
        <input type = "text" name="name" id="name"> <br>
        <label for="Author">Author</label><br>
        <input type = "text" name="Author" id="Author"> <br>
        <button type="submit">Add</button>
    </form>
    <a href='../Employer'>Back</a>
</body>
</html>