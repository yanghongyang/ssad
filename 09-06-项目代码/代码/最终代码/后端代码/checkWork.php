<?php
date_default_timezone_set ('Asia/Shanghai');
header("Access-Control-Allow-Origin:*");

header('Access-Control-Allow-Methods:POST');

header('Access-Control-Allow-Headers:x-requested-with, content-type');
$PID=$_POST['paperID'];
$UID=$_POST['userID'];
//$PID=1;
//$UID=1;
$con=@new mysqli("123.206.68.192", "mysqluser", "16211621");
//如果连接错误
if(mysqli_connect_errno()){
    echo "数据库连接失败"; //数据库连接失败
    $con=null;
    exit;
}
mysqli_set_charset($con,'utf8');
mysqli_select_db($con, "resource_sharing");

$time=date('Y-m-d H:i:s', time());
$checkSQL=("select title, abstract, source1, source2, source3, source4, time, cited, keyword, doi from achievement, paper ".
    "where achievement.id=paper.id and achievement.id='$PID'");
$insertSQL=("insert into browse(viewer, resource, time) values('$UID', '$PID', '$time')");
$runCheck=mysqli_query($con, $checkSQL);
$runInsert = mysqli_query($con, $insertSQL);
$data = array();
while ($row = mysqli_fetch_assoc($runCheck)) {
    $data[] = $row;
}
$json = json_encode($data);
echo $json;
//$utf8 = @preg_replace("/\\\u([0-9a-f]{4})/ie", "iconv('UTF-16BE', 'UTF-8', pack('H4','\\1'))", $json);
//echo $utf8;
//if($runInsert==TRUE){
  //  echo "插入成功";
//} else {
  //  echo "插入失败";
//}