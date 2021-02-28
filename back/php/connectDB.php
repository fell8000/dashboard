<?php
    header("Content-Type:text/html;charset=utf-8");
    //db연결
    $dbaddr = "localhost:43306";
    $dbId = "root";
    $dbPw = ""; // 패스워드
    $dbName = "welt"; // db이름
    $conn = mysql_connect($dbaddr, $dbId , $dbPw) or die ("실패입니다.");
    $dbconn = mysql_select_db($dbName, $conn);
    mysql_query("set session character_set_client=utf8");
    mysql_query("set session character_set_connection=utf8");
    mysql_query("set session character_set_results=utf8");
?>