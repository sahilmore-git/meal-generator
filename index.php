<?php
# Initialize the session
session_start();

# If user is not logged in then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== TRUE) {
  echo "<script>" . "window.location.href='./login.php';" . "</script>";
  exit;
}



# Include connection
require_once "./config.php";

$edit_err = "";
$meal_list="";
$username=htmlspecialchars($_SESSION["username"]);
$sql = "SELECT * FROM `users` WHERE username='$username'";
$result = $link->query($sql);
$user_data = $result->fetch_assoc();

$age=$user_data['age'];
$weight=$user_data['weight'];
$height = $user_data['height'];
$gender=$user_data['gender'];
$gender_text= $user_data['gender'] == 1  ? 'Female' : 'Male';
$maintain_calories = 0;
$noofmeals = 4;

switch ($gender){
    case '1':
        $maintain_calories= round(655 + (9.6 * $weight ) + (1.8 * $height) - (4.7 * $age));
        break;
    case '2':
        $maintain_calories= round(66 + (13.7 *$weight) + (5 * $height) - (6.8 * $age));
// references of calorie calculator: https://www.bodybuildbid.com/articles/weightloss/calorie-calculator.html
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/main.css">
  <link rel="shortcut icon" href="./img/favicon-16x16.png" type="image/x-icon">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
</head>

<body>
  <div class="container">
    <div class="alert alert-success my-5 text-center">
      Welcome! Look at your special meal plan.
    </div>
    <!-- User profile -->
    <div class="row">
      <div class="col-lg-5 text-center">
        <img src="./img/meal_logo.png" class="img-fluid rounded" alt="User avatar" width="180">
        <h4 class="my-4">Hello, <?= htmlspecialchars($_SESSION["username"]); ?></h4>
        <h4 class="my-4">Your Height(cm): <?= $height; ?></h4>
        <h4 class="my-4">Your Weight(kg): <?= $weight; ?></h4>
        <h4 class="my-4">Your Age(years): <?= $age; ?></h4>
        <h4 class="my-4">Gender: <?= $gender_text ?></h4>
        <a href="./logout.php" class="btn-primary text-danger">Log Out</a>
      </div>
      <div class="col-lg-5 justify-content-center align-items-center">
        <h4 class="my-4 text-center"> Your maintainance calories based on your data: </h4>
        <form id="mealform" method="POST">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-8 text-center">
                <input type="number" id="calories" class="form-control" min="100" max="40000" value=<?= $maintain_calories; ?> />
            </div>
        <h4 class="my-4 text-center"> Split in:  </h4>
            <div class="col-lg-8 text-center">
                <input type="number" id="noofmeals" class="form-control" min="1" max="9" value=<?= $noofmeals;?> />
            </div>
        <h4 class="my-4 text-center"> Meals. </h4>
            <div class="col-lg-8 text-center">
                <input type="submit" class="btn btn-primary form-control" id="mealplan" name="mealplan" value="Create Meal Plan">
            </div>
            <?php 
                if( $username == 'admin'){
                    echo '<div class="col-lg-8 text-center m-2">
                            <a href="./add_meal.php"><span class="btn btn-secondary">Add meal</span></a>
                            <a href="./edit_meal_select.php"><span class="btn btn-secondary">Edit meal</span></a>
                            <a href="./delete_meal.php"><span class="btn btn-secondary">Delete meal</span></a>
                        </div>';
                }
            ?>  
        </div>
        </form>
        </div>
    </div>
    <!-- Results -->

    <div id="result" class="row">
        
    </div>

  </div>
   <script type="text/javascript">

    $(document).ready(function (){
        $("#mealplan").click(function (){
            $('html, body').animate({
                scrollTop: $("#result").offset().top
            }, 2000);
        });
    });


    function chunkify(a, n, balanced) {
    
    if (n < 2)
        return [a];

    var len = a.length,
            out = [],
            i = 0,
            size;

    if (len % n === 0) {
        size = Math.floor(len / n);
        while (i < len) {
            out.push(a.slice(i, i += size));
        }
    }

    else if (balanced) {
        while (i < len) {
            size = Math.ceil((len - i) / n--);
            out.push(a.slice(i, i += size));
        }
    }

    else {

        n--;
        size = Math.floor(len / n);
        if (len % size === 0)
            size--;
        while (i < size * n) {
            out.push(a.slice(i, i += size));
        }
        out.push(a.slice(size * n));

    }

    return out;
}

    $('#mealform').submit(function(e) {
        e.preventDefault();
        let maintain_calories = $('#calories').val();
        var no_of_meals = $('#noofmeals').val();
        
        $.ajax({
            type: "POST",
            url: './meal_plan_logic.php',
            data: {"calories":maintain_calories},
            success: function(response)
            {   
                var jsonArr = JSON.parse(response);
                console.log(jsonArr);
                resArr = chunkify(jsonArr, no_of_meals, true);
                console.log(resArr);
                let html_content = "";
                for (let i = 0; i < resArr.length; i++) {
                    html_content += '<h3 class="text-center"> Meal #'+(i+1)+'</h3>';
                    for( let j=0; j < resArr[i].length; j++){
                        let curr_element= resArr[i];
                        html_content += '<div class="col-lg-12 m-1 bg-light text-center border border-secondary"> <span class="text-info">Dish Name:</span> '+curr_element[j].name+'  <br/> <span class="text-warning">Calories:</span> '+curr_element[j].calories+' <br/> <span class="text-success">Recipe:</span> '+curr_element[j].recipe+' </div>';
                    }
                }

                $('#result').html(html_content);
           }

       });

     });
</script>
</body>

</html>