<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = mysqli_real_escape_string($con, $_POST['email']);

    $query = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";
    
    if (mysqli_query($con, $query)) {
        
        header("Location: login.php");
        exit; 
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>


<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = mysqli_real_escape_string($con, $_POST['email']);

    $query = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";
    
    if (mysqli_query($con, $query)) {
     
        header("Location: login.php");
        exit; 
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FoodieClub - Register</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="auth-page"> 
    <div class="container">
        <img src="logo.jpeg" alt="FoodieClub Logo" class="logo">
        <h2>Register</h2>
        <form method="post" action="register.php">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>
            
            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="./login.php">Login here</a></p> 
    </div>
</body>
</html>
