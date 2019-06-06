<?php
$uid = $_POST['UID'];
$pid = $_POST['PID'];

//$uid = "1";
//$pid = "100";

$con=@new mysqli("123.206.68.192", "mysqluser", "16211621");
//如果连接错误
if(mysqli_connect_errno()){
    echo 2; //数据库连接失败
    $con=null;
    exit;
}
mysqli_set_charset($con,'utf8');
mysqli_select_db($con, "resource_sharing");

$sqlcheck = ("select count(*) from collection where pid = '$pid' and uid = '$uid';" );
$runcheck = mysqli_query($con, $sqlcheck);
$resultcheck = mysqli_fetch_array($runcheck);
if($resultcheck[0] > 0)
{
    echo 0;
}
else
{
    echo 1;
}
?>