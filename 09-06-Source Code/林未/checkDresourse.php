﻿<?php
$uid = $_POST['downloader'];

//$uid = 2;

$con=@new mysqli("123.206.68.192", "mysqluser", "16211621");
//如果连接错误
if(mysqli_connect_errno()){
    echo "数据库连接失败"; //数据库连接失败
    $con=null;
    exit;
}
mysqli_set_charset($con,'utf8');
mysqli_select_db($con, "test");

$sqlcheck = ("select resource, download.time as time, title, author, paper.date as date, cited from download, achievement, paper where resource = achievement.id and achievement.id = paper.id and downloader = '$uid';" );
$runcheck = mysqli_query($con, $sqlcheck);
$data = array();
while ($row = mysqli_fetch_assoc($runcheck)) {
    $data[] = $row;
}
$json = json_encode($data);
echo $json;
?>