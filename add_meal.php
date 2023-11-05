<?php
# Initialize session
session_start();


# Include connection
require_once "./config.php";

$add_err = "";

# Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  if (empty(trim($_POST["name"])) || empty(trim($_POST["type"])) || empty(trim($_POST["category"])) || empty(trim($_POST["calories"])) || empty(trim($_POST["recipe"]))) {
    $add_err = "Please enter correct details.";
  } 

  # Validate credentials 
  if (empty($add_err)) {
    # Prepare a select statement
    $sql = "INSERT INTO meals(name, type, category, calories, recipe) VALUES (?, ?, ?, ?, ?)";
    if ($stmt = mysqli_prepare($link, $sql)) {
      # Bind variables to the statement as parameters
      mysqli_stmt_bind_param($stmt, "siiss", $name, $type, $category, $calories, $recipe);
      # Set parameters
      $name = trim($_POST["name"]);
      $type = intval(trim($_POST["type"]));
      $category = intval(trim($_POST["category"]));
      $calories = trim($_POST["calories"]);
      $recipe = trim($_POST["recipe"]);

      # Execute the statement
      if (mysqli_stmt_execute($stmt)) {
        # Store result
        $res = mysqli_stmt_store_result($stmt);
        # Check if user exists, If yes then verify password
        if ($res > 0) {
            echo "<script>" . "alert('Meal Added Sucessfully.');" . "</script>";
            echo "<script>" . "window.location.href='./add_meal.php'" . "</script>";
            exit;
      } else {
            echo "<script>" . "alert('Oops! Something went wrong. Please try again later.');" . "</script>";
            echo "<script>" . "window.location.href='./login.php'" . "</script>";
            exit;
        }
      # Close statement
      mysqli_stmt_close($stmt);
    }
  }
  else{
        $add_err="Something went wrong";
  }
}
  # Close connection
  mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Meal</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/main.css">
  <link rel="shortcut icon" href="./img/favicon-16x16.png" type="image/x-icon">
  <script defer src="./js/script.js"></script>
</head>

<body>
  <div class="container">
    <div class="row min-vh-100 justify-content-center align-items-center">
      <div class="col-lg-5">
        <?php
        if (!empty($login_err)) {
          echo "<div class='alert alert-danger'>" . $login_err . "</div>";
        }
        ?>
        <div class="form-wrap border rounded p-4">
          <h1>Add Meal</h1>
          <p>Add new meal</p>
          <!-- form starts here -->
          <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate>
            <div class="mb-3">
              <label for="user_login" class="form-label">Name</label>
              <input type="text" class="form-control" name="name" id="name" value="">
            </div>
            <div class="mb-2">
                <label for="type" class="form-label">Meal Type</label>
                <select name="type" class="form-control" id="type">
                    <option value="" selected>--Select Meal Type--</option>
                    <option value="1">Breakfast</option>
                    <option value="2">Lunch</option>
                    <option value="3">Snacks</option>
                    <option value="4">Dinner</option>
                </select>
            </div>
            <div class="mb-2">
                <label for="category" class="form-label">Meal Category</label>
                <select name="category" class="form-control" id="category">
                    <option value="" selected>--Select Meal Category--</option>
                    <option value="1">Veg</option>
                    <option value="2">Non-Veg</option>
                </select>
            </div>
            <div class="mb-3">
              <label for="user_login" class="form-label">Calories</label>
              <input type="number" class="form-control" name="calories" id="calories" value="">
            </div>
            <div class="mb-3">
              <label for="user_login" class="form-label">Recipe</label>
              <textarea id="recipe" name="recipe" class="form-control" rows="4" cols="50"></textarea>
            </div>
            <div class="mb-3">
              <small class="text-danger"><?= $add_err; ?></small>
              <input type="submit" class="btn btn-primary form-control" name="submit" value="Add Meal">
            </div>
            <p class="mb-0">Want to edit? <a href="./edit_meal_select.php">Edit Meal</a></p>
            <p class="mb-0">Go Back? <a href="./index.php">Home</a></p>
          </form>
          <!-- form ends here -->
        </div>
      </div>
    </div>
  </div>
</body>

</html>