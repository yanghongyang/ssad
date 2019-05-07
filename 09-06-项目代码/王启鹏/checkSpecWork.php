<?php

//$UID=$_POST['userID'];
//$specName=$_POST['specName'];
$UID = 1;
$specName="test";
$con = @new mysqli("123.206.68.192", "mysqluser", "16211621");
//如果连接错误
if (mysqli_connect_errno()) {
    echo 3; //数据库连接失败
    $con = null;
    exit;
}
mysqli_set_charset($con, 'utf8');
mysqli_select_db($con, "test");

$sql=("select paper.ID as paperID, title, paper.date as time, cited as citedNum from achievement, specialist_achievement, specialist ".
    "where achievement=specialist_achievement.aid and specialist.id=specialist_achievement.sid and specialist.name='$specName'");
$runSQL=mysqli_query($con, $sql);
$data = array();
while ($row = mysqli_fetch_assoc($runCheck)) {
    $data[] = $row;
}
$json = json_encode($data);
$utf8 = @preg_replace("/\\\u([0-9a-f]{4})/ie", "iconv('UTF-16BE', 'UTF-8', pack('H4','\\1'))", $json);
echo $utf8;
