<?php
include 'db.php';
session_start();
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
   

    <?php if (!isset($_SESSION['user_id'])) { ?>
        <div style="text-align: center;">
            <a href="login.php">Login</a> | <a href="register.php">Register</a>
        </div>
        <img src="club.jpg">
    <?php } else {
        $user_id = $_SESSION['user_id'];

        
        $query = "SELECT * FROM recipes";
        $recipes_result = mysqli_query($con, $query);
    ?>
        <a href="add_recipe.php">Add New Recipe</a>
        <h3>Recipes:</h3>
        <ul>
            <?php while ($recipe = mysqli_fetch_assoc($recipes_result)) { 
                $recipe_id = $recipe['id'];

          
                $rating_query = "SELECT AVG(rating) AS avg_rating FROM ratings WHERE recipe_id = $recipe_id";
                $rating_result = mysqli_query($con, $rating_query);
                $rating_data = mysqli_fetch_assoc($rating_result);
                $average_rating = round($rating_data['avg_rating'], 1) ?: "No ratings yet";

                
                $comment_query = "SELECT comments.*, users.username FROM comments 
                                  JOIN users ON comments.user_id = users.id 
                                  WHERE recipe_id = $recipe_id";
                $comments_result = mysqli_query($con, $comment_query);
            ?>
                <li>
                    <h4><?php echo $recipe['title']; ?></h4>
                    <p><strong>Ingredients:</strong> <?php echo $recipe['ingredients']; ?></p>
                    <p><strong>Instructions:</strong> <?php echo $recipe['instructions']; ?></p>
                    <p><strong>Average Rating:</strong> ⭐ <?php echo $average_rating; ?>/5</p>

                   
                    <form method="post" action="add_rating.php">
                        <label for="rating">Rate this recipe:</label>
                        <select name="rating" required>
                            <option value="1">1 - Poor</option>
                            <option value="2">2 - Fair</option>
                            <option value="3">3 - Good</option>
                            <option value="4">4 - Very Good</option>
                            <option value="5">5 - Excellent</option>
                        </select>
                        <input type="hidden" name="recipe_id" value="<?php echo $recipe_id; ?>">
                        <button type="submit">Submit Rating</button>
                    </form>

                    <h5>Comments:</h5>
                    <ul>
                        <?php while ($comment = mysqli_fetch_assoc($comments_result)) { ?>
                            <li class="comment-box">
                                <strong><?php echo $comment['username']; ?>:</strong>
                                <p><?php echo $comment['comment']; ?></p>
                                <small><?php echo $comment['created_at']; ?></small>

                                
                                <?php if ($comment['user_id'] == $_SESSION['user_id']) { ?>
                                    <a href="edit_comment.php?id=<?php echo $comment['id']; ?>">Edit</a> | 
                                    <a href="delete_comment.php?id=<?php echo $comment['id']; ?>" 
                                       onclick="return confirm('Are you sure you want to delete this comment?');">Delete</a>
                                <?php } ?>
                            </li>
                        <?php } ?>
                    </ul>

                    <form method="post" action="add_comment.php">
                        <textarea name="comment" placeholder="Add a comment" required></textarea><br>
                        <input type="hidden" name="recipe_id" value="<?php echo $recipe['id']; ?>">
                        <button type="submit">Add Comment</button>
                    </form>
                </li>
            <?php } ?>
        </ul>
        <a href="logout.php">Logout</a>
        
    <?php } ?>
</body>
</html>
