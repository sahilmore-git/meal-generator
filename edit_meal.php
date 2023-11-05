<?php
# Initialize session
session_start();


# Include connection
require_once "./config.php";
$edit_err="";
if(isset($_POST['editmealsubmit'])){

    $name=trim($_POST["name"]);
    $type=trim($_POST["type"]);
    $category=trim($_POST["category"]);
    $calories=trim($_POST["calories"]);
    $recipe=trim($_POST["recipe"]);
    $meal_id=trim($_POST["meal_id"]);

    if (empty($name) || empty($type) || empty($calories) || empty($category) || empty($recipe) || empty($meal_id) ) {
        $edit_err = "Please enter correct details.";
    } 

if (empty($edit_err)) {
    # Prepare a select statement
    $sql = "UPDATE meals SET name='$name',type=$type, category=$category, calories=$calories, recipe='$recipe' WHERE id=".$meal_id;
    if ($link->query($sql) === TRUE) {
            echo "<script>" . "alert('Meal Edited Sucessfully.');" . "</script>";
            echo "<script>" . "window.location.href='./edit_meal_select.php'" . "</script>";
            exit;
      } else {
            echo "<script>" . "alert('Oops! Something went wrong. Please try again later.');" . "</script>";
            echo "<script>" . "window.location.href='./edit_meal_select.php'" . "</script>";
            exit;
    }
      # Close statement
      mysqli_stmt_close($stmt);
  }
}
else{
# Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $meal_id = trim($_POST['meal']);    
  
  if (empty($meal_id)) {
    echo "<script>" . "alert('Oops! Something went wrong. Please try again later.');" . "</script>";
    echo "<script>" . "window.location.href='./edit_meal_select.php'" . "</script>";
    exit;
  } 

  $sql = "SELECT * FROM meals WHERE id=".$meal_id;
  $result = $link->query($sql);
  $meal_data = $result->fetch_assoc();
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
  <title>Edit Meal</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/main.css">
  <link rel="shortcut icon" href="./img/favicon-16x16.png" type="image/x-icon">
  <script defer src="./js/script.js"></script>
</head>

<body>
  <div class="container">
    <div class="row min-vh-100 justify-content-center align-items-center">
      <div class="col-lg-5">
        <div class="form-wrap border rounded p-4">
          <h1>Edit Meal</h1>
          <p>Edit meal data</p>
          <!-- form starts here -->
          <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate>
            <div class="mb-3">
              <label for="user_login" class="form-label">Name</label>
              <input type="text" class="form-control" name="name" id="name" value="<?= $meal_data['name'];?>">
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
            <input type="hidden" name="meal_id" value="<?= $meal_id ?>;">
            <div class="mb-3">
              <label for="user_login" class="form-label">Calories</label>
              <input type="number" class="form-control" name="calories" id="calories" value="<?= $meal_data['calories'];?>">
            </div>
            <div class="mb-3">
              <label for="user_login" class="form-label">Recipe</label>
              <textarea id="recipe" name="recipe" class="form-control" rows="4" cols="50"><?= $meal_data['recipe'];?></textarea>
            </div>
            <div class="mb-3">
              <small class="text-danger"><?= $edit_err; ?></small>
              <input type="submit" class="btn btn-primary form-control" name="editmealsubmit" value="Edit Meal">
            </div>
          </form>
          <!-- form ends here -->
        </div>
      </div>
    </div>
  </div>
</body>

</html>