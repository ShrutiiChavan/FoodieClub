<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    echo "Invalid request!";
    exit();
}

$comment_id = $_GET['id'];
$user_id = $_SESSION['user_id'];


$query = "SELECT * FROM comments WHERE id = $comment_id AND user_id = $user_id";
$result = mysqli_query($con, $query);
$comment = mysqli_fetch_assoc($result);

if (!$comment) {
    echo "Comment not found or you are not allowed to edit this comment.";
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_comment = mysqli_real_escape_string($con, $_POST['comment']);
    
    $update_query = "UPDATE comments SET comment='$new_comment' WHERE id=$comment_id AND user_id=$user_id";
    
    if (mysqli_query($con, $update_query)) {
        header("Location: index.php"); 
        exit();
    } else {
        echo "Error updating comment!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Comment</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Edit Comment</h2>
    <form method="post">
        <textarea name="comment" required><?php echo htmlspecialchars($comment['comment']); ?></textarea><br>
        <button type="submit">Update Comment</button>
    </form>
</body>
</html>
