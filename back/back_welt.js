$(function(){
	var date = '2019-06-20';
	var time = '18:00:00';
	var user_id = '1nhBflpO9ehPOndqzldvHWB3ILS2'
	var category = 1; // 0 : step, 1 : waist, 2 : calory
	//getRankingData(user_id, category, date);
	//getUserData(user_id,date,time);
	getTimeIntervalData(user_id, date);
	//getUserCondition(user_id, date);

})


function getUserData(user_id, date, time){
	$.ajax({
		url:"php/userData.php",
		type : "GET",
		dataType:"json",
		data : {"user_id":user_id, "date":date, "time":time},
		success:function(data){
			// create code..
			console.log(data);
		}
	})
}

function getUserCondition(user_id, date){
	$.ajax({
		url:"php/userCondition.php",
		type : "GET",
		dataType:"json",
		data : {"user_id":user_id, "date":date},
		success:function(data){
			// create code..
			console.log(data);
		}
	})
}

function getRankingData(user_id, category, date, time){
	$.ajax({
		url:"php/ranking.php",
		type : "GET",
		dataType:"json",
		data : {"user_id":user_id, "category":category, "date":date},
		success:function(data){
			// create code..
			console.log(data);
		}
	})
}

function getTimeIntervalData(user_id, date){
	$.ajax({
		url:"php/timeInterval.php",
		type : "GET",
		dataType:"json",
		data : {"user_id":user_id, "date":date},
		success:function(data){
			// create code..
			console.log(data);
		}
	})
}
