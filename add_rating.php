<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $recipe_id = mysqli_real_escape_string($con, $_POST['recipe_id']);
    $rating = mysqli_real_escape_string($con, $_POST['rating']);

    $query = "INSERT INTO ratings (user_id, recipe_id, rating) VALUES ('$user_id', '$recipe_id', '$rating')";
    
    if (mysqli_query($con, $query)) {
        header('Location: index.php');
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>
