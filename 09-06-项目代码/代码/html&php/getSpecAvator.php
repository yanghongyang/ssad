<?php
$sid = $_POST['SID'];

//$sid = 2;

$con=@new mysqli("123.206.68.192", "mysqluser", "16211621");
//如果连接错误
if(mysqli_connect_errno()){
    echo "数据库连接失败"; //数据库连接失败
    $con=null;
    exit;
}
mysqli_set_charset($con,'utf8');
mysqli_select_db($con, "test");

$sqlcheck = ("select avator expert from user where expert = '$sid';" );
$runcheck = mysqli_query($con, $sqlcheck);
$row = mysqli_fetch_assoc($runcheck);
$json = json_encode($row);
//$utf8 = @preg_replace("/\\\u([0-9a-f]{4})/ie", "iconv('UTF-16BE', 'UTF-8', pack('H4','\\1'))", $json);
echo $json;
?>