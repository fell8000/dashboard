<?php
include 'connectDB.php';
$user_id = $_GET['user_id'];
$date = $_GET['date'];
$time = $_GET['time'];


$sitting_condition = getUserCondition_sitting($user_id, $date);
$waist_condition = getUserCondition_waist($user_id, $date);

$condition = array('sitting' => $sitting_condition, 'waist' => $waist_condition);
echo json_encode($condition);

function getUserCondition_sitting($uid, $date){
   $sql = "SELECT * FROM ".$uid." WHERE waist > 0 AND step >=0 AND time_z LIKE '".$date."%'";

   $cnt_sit=0;
   $userData = mysql_query($sql);
   while($row = mysql_fetch_array($userData)){
      if($row['sitting']==1){
         $cnt_sit+=1;
         if($cnt_sit==4){
            return 1;
            break;
         }
      }else{
         $cnt_sit=0;
      }
   }
   return 0;
}

function getUserCondition_waist($uid, $date){
   //한달 기준
   $sql = "select * from ".$uid." where waist>0 and step >=0 and time_z like '".$date."%'";

   $cnt_waist=0;
   $userData = mysql_query($sql);

   $waist_array = array();

   while($row = mysql_fetch_array($userData)){

      array_push($waist_array,$row['waist']);
   }

   $max = max($waist_array);
   $min = min($waist_array);

   if($max-$min>=2){
      //echo "허리둘레가 ".($max-$min)."만큼 늘어났습니다.";
      return 1;
   }
   return 0;
}



?>