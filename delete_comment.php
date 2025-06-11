

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
    echo "Comment not found or you are not allowed to delete this comment.";
    exit();
}


$delete_query = "DELETE FROM comments WHERE id = $comment_id AND user_id = $user_id";
if (mysqli_query($con, $delete_query)) {
    header("Location: index.php"); 
    exit();
} else {
    echo "Error deleting comment!";
}
?>
