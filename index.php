<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch recipes
$query = "SELECT * FROM recipes";
$recipes_result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FoodieClub - Home</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Welcome to FoodieClub!</h2>
    <a href="add_recipe.php">Add New Recipe</a>
    <h3>Recipes:</h3>
    <ul>
        <?php while ($recipe = mysqli_fetch_assoc($recipes_result)) { 
            $recipe_id = $recipe['id'];
            
            // Fetch comments
            $comment_query = "SELECT comments.*, users.username FROM comments JOIN users ON comments.user_id = users.id WHERE recipe_id = $recipe_id";
            $comments_result = mysqli_query($con, $comment_query);

            // Fetch ratings
            $rating_query = "SELECT AVG(rating) as average_rating FROM ratings WHERE recipe_id = $recipe_id";
            $rating_result = mysqli_query($con, $rating_query);
            $average_rating = mysqli_fetch_assoc($rating_result)['average_rating'];
            ?>
            <li>
                <h4><?php echo $recipe['title']; ?></h4>
                <p><strong>Ingredients:</strong> <?php echo $recipe['ingredients']; ?></p>
                <p><strong>Instructions:</strong> <?php echo $recipe['instructions']; ?></p>
                <p><strong>Average Rating:</strong> <?php echo $average_rating ? number_format($average_rating, 2) : 'No ratings yet'; ?></p>
                
                <h5>Comments:</h5>
                <ul>
                    <?php while ($comment = mysqli_fetch_assoc($comments_result)) { ?>
                        <li>
                            <strong><?php echo $comment['username']; ?>:</strong>
                            <p><?php echo $comment['comment']; ?></p>
                            <small><?php echo $comment['created_at']; ?></small>
                        </li>
                    <?php } ?>
                </ul>

                <form method="post" action="add_comment.php">
                    <textarea name="comment" placeholder="Add a comment" required></textarea><br>
                    <input type="hidden" name="recipe_id" value="<?php echo $recipe['id']; ?>">
                    <button type="submit">Add Comment</button>
                </form>

                <form method="post" action="add_rating.php">
                    <label for="rating">Rate this recipe:</label>
                    <select name="rating" id="rating" required>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                    <input type="hidden" name="recipe_id" value="<?php echo $recipe['id']; ?>">
                    <button type="submit">Rate</button>
                </form>
            </li>
        <?php } ?>
    </ul>
    <a href="logout.php">Logout</a>
</body>
</html>
