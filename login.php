<?php
include 'db.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header('Location: index.php');
        } else {
            echo "Invalid username or password!";
        }
    } else {
        echo "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FoodieClub - Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<body class="auth-page">
    <div class="container">
        <img src="logo.jpeg" alt="FoodieClub Logo" class="logo"> 
        <h2>Login</h2>
        <form method="post" action="login.php">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="./register.php">Register here</a></p>
    </div>
</body>

</body>
</html>
