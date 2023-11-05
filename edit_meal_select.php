<?php
# Initialize session
session_start();


# Include connection
require_once "./config.php";

$edit_err = "";
$meal_list="";

$sql = "SELECT * FROM meals";
$meal_list = $link->query($sql);

# Close connection
mysqli_close($link);

# Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  if (empty(trim($_POST["meal"]))) {
    $edit_err = "Please select a meal.";
  }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Select Meal</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/main.css">
  <link rel="shortcut icon" href="./img/favicon-16x16.png" type="image/x-icon">
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
          <h1>Select Meal</h1>
          <p>Select meal to edit</p>
          <!-- form starts here -->
          <form action="./edit_meal.php" method="post" novalidate>
            <div class="mb-2">
                <label for="meal" class="form-label">Select Meal</label>
                <select name="meal" class="form-control" id="select_meal_dd" onchange="mealSelected(this.value)">
                    <option value="0">--Select Meal--</option>
                    <?php 
                        if ($meal_list->num_rows > 0) {
                        while($row = $meal_list->fetch_assoc()) {
                            echo "<option value=". $row['id'].">". $row["name"]."</option>";
                        }
                        }
                    ?>
                </select>
            </div>
            <div class="mb-3">
              <small class="text-danger"><?= $edit_err; ?></small>
              <input type="submit" class="btn btn-primary form-control" id="edit_meal_select_submit" name="submit" value="Edit Meal">
            </div>
            <p class="mb-0">Want to add instead? <a href="./add_meal.php">Add Meal</a></p>
            <p class="mb-0">Go Back? <a href="./index.php">Home</a></p>
          </form>
          <!-- form ends here -->
        </div>
      </div>
    </div>
  </div>
    <script type="text/javascript">
        let edit_meal_select_submit = document.getElementById('edit_meal_select_submit');
        edit_meal_select_submit.setAttribute("disabled", "true");
        function mealSelected(value) {
            if(value != ""){
                edit_meal_select_submit.removeAttribute("disabled");
            }
            else{
                edit_meal_select_submit.setAttribute("disabled", "true");
            }
        }
    </script>
</body>

</html>