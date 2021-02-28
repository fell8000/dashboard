<?php
include 'connectDB.php';

$userId = $_GET['user_id'];
$category = $_GET['category'];
$nowDate = $_GET['date'];

$userAge;
$userGender;
$sameAgeUidList = array();
$userQeury = "SELECT * FROM body_info WHERE uid = '".$userId."'";
$userData = mysql_query($userQeury);

while($row = mysql_fetch_array($userData)){
	$userAge = (date('Y')-$row['age'])+1;
	$userGender = $row['male'];
};
$ageRange = ($userAge-($userAge%10));
	// 같은 나이대 구하기
$ageQeury = "SELECT * FROM body_info WHERE ".date('Y')."-age BETWEEN ".$ageRange." and ".($ageRange+9)." AND male = ".$userGender;

$sameAgeUserData = mysql_query($ageQeury);

$ranking;

switch($category){
	case '0':
	$ranking = getRankingStep($sameAgeUserData, $nowDate);
	break;
	case '1':
	$ranking = getRankingWaist($sameAgeUserData, $nowDate, $time);
	break;
	case '2':
	$ranking = getRankingCalories($sameAgeUserData, $nowDate);
	break;
}

$myRank = array();
$cnt = 1;
foreach ($ranking as $key => $value) {
	if($cnt<6){
		$rankingArray[] = array('rank' => $cnt, 'user_id' => $key, 'value' => $value);
	}
	if($key == $userId){
		array_push($myRank, $rankingArray[$cnt-1]);
	}
	$cnt++;
}

function han ($s) { return reset(json_decode('{"s":"'.$s.'"}')); }
function to_han ($str) { return preg_replace('/(\\\u[a-f0-9]+)+/e','han("$0")',$str); }
// $rank_json = json_encode($rankingArray);
// $myrank_json = json_encode($myRank);
$json = array("user_rank"=>$myRank, "top5 rank"=>$rankingArray);
echo json_encode($json);
// $json = json_encode($json);
// $json = str_replace('\\', '', $json);
// $json = preg_replace('!\s+!', ' ', $json);
// echo to_han($json);




function getRankingStep($result,$now){
	$step_ranking = array();
	$currentDate = $now;
	while($row = mysql_fetch_array($result)){
		$query = "SELECT sum(step) FROM ".$row['uid']." WHERE time_z LIKE '".$currentDate."%'";
		$step = mysql_query($query);
		$step_result = mysql_result($step, 0,0);
		if(empty($step_result)){
			continue;	
		}
		$step_ranking[$row['uid']] = $step_result;
	};
	// 내림차순
	arsort($step_ranking);
	return $step_ranking;

}

function getRankingWaist($result,$now){
	$waist_ranking = array();
	$currentDate = $now;
	while($row = mysql_fetch_array($result)){
		$query = "SELECT waist FROM ".$row['uid']." WHERE time_z Like '".$currentDate."%' AND waist > 0";
		$waists = mysql_query($query);
		while ($row2 = mysql_fetch_array($waists)) {
			$waist_ranking[$row['uid']] = $row2['waist'];
		}
		
	}
	asort($waist_ranking);
	return $waist_ranking;
}

function getRankingCalories($result, $now){
	$calory_ranking = array();
	$currentDate = $now;

	while($row = mysql_fetch_array($result)){
		$query = "SELECT sum(step) FROM ".$row['uid']." WHERE time_z LIKE '".$currentDate."%'";
		$ret = mysql_query($query);
		$step_result = mysql_result($ret, 0,0);
		
		$calory = $step_result*0.0003*$row['height']*$row['weight']*0.01;
		$calory_ranking[$row['uid']] = $calory;
	}
	arsort($calory_ranking);
	return $calory_ranking;
}

?>



