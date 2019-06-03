<?php
$SID=$_POST['SID'];
// $SID=2;

$con=@new mysqli("123.206.68.192", "mysqluser", "16211621");
//如果连接错误
if(mysqli_connect_errno()){
    echo "连接失败"; //数据库连接失败
    $con=null;
    exit;
}
mysqli_set_charset($con,'utf8');
mysqli_select_db($con, "resource_sharing");

$sql=("select * from specialist where id in ".
    "(select SA2.sid from specialist_achievement SA1, specialist_achievement SA2 where SA1.aid=SA2.aid and SA1.sid='$SID' and SA1.sid<>SA2.sid)");
$runSQL=mysqli_query($con, $sql);
$data = array();
while ($row = mysqli_fetch_assoc($runSQL)) {
    $data[] = $row;
}
// var_dump($data);

$json = json_encode($data);
echo($json);
// $utf8 = @preg_replace("/\\\u([0-9a-f]{4})/ie", "iconv('UTF-16BE', 'UTF-8', pack('H4','\\1'))", $json);
// var_dump($utf8);
// echo $utf8;
// echo 123;

