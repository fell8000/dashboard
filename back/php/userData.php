<?php
include 'connectDB.php';
$user_id = $_GET['user_id'];
$date = $_GET['date'];
$time = $_GET['time'];

$result = getUserData($user_id, $date, $time);
echo json_encode($result);




function getUserData($uid, $date, $time){
   $sql = "SELECT * FROM body_info WHERE uid like '".$uid."'";
   $query = "SELECT sum(step) FROM ".$uid." WHERE time_z LIKE '".$date."%'";
   $userData = mysql_query($sql);
   $step = mysql_query($query);

   $total_step = mysql_result($step, 0,0);
   $current_waist = getUserCurruntWaist($uid, $date, $time);
   $total_sitting = getUserSittingTime($uid, $date);

   while($row = mysql_fetch_array($userData)){
      $total_distance += $row['height']*0.00037*$total_step*0.01;
      $total_kal += $total_step*0.0003*$row['height']*$row['weight']*0.01;
   };

   $data = array('calory' => $total_kal, 'step' => (int)$total_step, 'distance' => $total_distance, 'sitting' => $total_sitting, 'waist' => $current_waist);
   return $data;
}

function getUserCurruntWaist($uid, $date, $time){
    $query = "SELECT waist FROM ".$uid." WHERE time_z like '".$date." ".$time."'";
    $userData = mysql_query($query);
    $userData = mysql_result($userData, 0,0);
    return $userData;
}

function getUserSittingTime($uid, $date){
   $sql = "SELECT * FROM ".$uid." WHERE waist>0 AND step >=0 AND time_z LIKE '".$date."%'";
   $userData = mysql_query($sql);

   $cnt_sit = 0;
   while($row = mysql_fetch_array($userData)){
      $cnt_sit+=$row['sitting'];
   }

   return $cnt_sit*30;
}






// function getUserData_height($uid){
//    $sql = "select height from body_info where uid like '".$uid."'";
//    $userData = mysql_query($sql);

//    while($row = mysql_fetch_array($userData)){
//       return $row['height'];
//    };

// }

// function getUserData_weight($uid){
//    $sql = "select weight from body_info where uid like '".$uid."'";
//    $userData = mysql_query($sql);

//    while($row = mysql_fetch_array($userData)){
//       return $row['weight'];
//    };

// }


// function getUserData($uid, $date){
//    $sql = "select * from ".$uid." where waist>0 and step >0 and time_z like '".$date."%'";
//    $height = getUserData_height();
//    $weight = getUserData_weight();

//    $userData = mysql_query($sql);

//    while($row = mysql_fetch_array($userData)){
//       $step_sum +=  $row['step'];
//    }


//    $total_distance += $height*0.00037*$step_sum*0.01;
//    $total_kal += $step_sum*0.0003*$height*$weight*0.01;
   
//    $result = array($total_distance, $total_kal);
//    return $result;
//    //return $step_sum, $total_distance, $total_kal; 
// }

?>