<?php    
    # Initialize session
    session_start();


    # Include connection
    require_once "./config.php";

    $total_calories = $_POST['calories'];
    
    $breakfast_sql = "SELECT * FROM meals WHERE type='1' ORDER BY calories ASC";
    $lunch_sql = "SELECT * FROM meals WHERE type='2' ORDER BY calories ASC";
    $snacks_sql = "SELECT * FROM meals WHERE type='3' ORDER BY calories ASC";
    $dinner_sql = "SELECT * FROM meals WHERE type='4' ORDER BY calories ASC";
    
    $breakfast_list = $link->query($breakfast_sql);
    $lunch_list = $link->query($lunch_sql);
    $snacks_list = $link->query($snacks_sql);
    $dinner_list = $link->query($dinner_sql);

    mysqli_close($link);

    $breakfast_calories = round($total_calories*0.2);
    $lunch_calories = round($total_calories*0.3);
    $snacks_calories = round($total_calories*0.2);
    $dinner_calories = round($total_calories*0.3);

    $breakfast_tolerance = -100;
    $lunch_tolerance = -200;
    $snacks_tolerance = -100;
    $dinner_tolerance = -200;
    $planned_meal = [];
    $idx = 0;

    $cal_done=0;

    if ($breakfast_list->num_rows > 0) {
        while($row = $breakfast_list->fetch_assoc()) {
            $current_balance_calories = $breakfast_calories - $row['calories'];
            if( $current_balance_calories > $breakfast_tolerance){
                $cal_done+=$row['calories'];
                $planned_meal[$idx++] = $row;
                $breakfast_calories =  $current_balance_calories;
            }
        }
    }

    if ($lunch_list->num_rows > 0) {
        while($row = $lunch_list->fetch_assoc()) {
            $current_balance_calories = $lunch_calories - $row['calories'];
            if( $current_balance_calories > $lunch_tolerance){
                $cal_done+=$row['calories'];
                $planned_meal[$idx++] = $row;
                $lunch_calories = $current_balance_calories;
            }
        }
    }

    if ($snacks_list->num_rows > 0) {
        while($row = $snacks_list->fetch_assoc()) {
            $current_balance_calories = $snacks_calories - $row['calories'];
            if( $current_balance_calories > $snacks_tolerance){
                $cal_done+=$row['calories'];
                $planned_meal[$idx++] = $row;
                $snacks_calories = $current_balance_calories;
            }
        }
    }

    if ($dinner_list->num_rows > 0) {
        while($row = $dinner_list->fetch_assoc()) {
            $current_balance_calories = $dinner_calories - $row['calories'];
            if( $current_balance_calories > $dinner_tolerance){
                $cal_done+=$row['calories'];
                $planned_meal[$idx++] = $row;
                $dinner_calories = $current_balance_calories;
            }
        }
    }    

    // print_r($cal_done);
    echo json_encode($planned_meal);
?>