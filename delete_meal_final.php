<?php
# Initialize session
session_start();


# Include connection
require_once "./config.php";

# Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $meal_id = trim($_POST['meal']);    
  
  if (empty($meal_id)) {
    echo "<script>" . "alert('Oops! Something went wrong. Please try again laterr.');" . "</script>";
    echo "<script>" . "window.location.href='./edit_meal_select.php'" . "</script>";
    exit;
  } 

  $sql = "DELETE FROM meals WHERE id=".$meal_id;
  $result = $link->query($sql);
  # Close connection
  mysqli_close($link);

  if($result){
     echo "<script>" . "alert('Deleted Successfully.');" . "</script>";
    echo "<script>" . "window.location.href='./delete_meal.php'" . "</script>";
    exit;
  }
  else{
     echo "<script>" . "alert('Oops! Something went wrong. Please try again later.');" . "</script>";
    echo "<script>" . "window.location.href='./delete_meal.php'" . "</script>";
    exit;
  }

}

?>