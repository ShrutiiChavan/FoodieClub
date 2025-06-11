<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $ingredients = mysqli_real_escape_string($con, $_POST['ingredients']);
    $instructions = mysqli_real_escape_string($con, $_POST['instructions']);

    $query = "INSERT INTO recipes (user_id, title, ingredients, instructions) VALUES ('$user_id', '$title', '$ingredients', '$instructions')";
    
    if (mysqli_query($con, $query)) {
        header('Location: index.php');
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FoodieClub - Add Recipe</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Add New Recipe</h2>
    <form method="post" action="add_recipe.php">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required><br>
        <label for="ingredients">Ingredients:</label>
        <textarea id="ingredients" name="ingredients" required></textarea><br>
        <label for="instructions">Instructions:</label>
        <textarea id="instructions" name="instructions" required></textarea><br>
        <button type="submit">Add Recipe</button>
    </form>
</body>
</html>
