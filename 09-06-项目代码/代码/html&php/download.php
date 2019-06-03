<?php
$uid = $_POST['userId'];
$res = $_POST['resource'];

//$uid = 3;
//$res = 1;

$con=@new mysqli("123.206.68.192", "mysqluser", "16211621");
//如果连接错误
if(mysqli_connect_errno()){
    echo 2; //数据库连接失败
    $con=null;
    exit;
}
mysqli_set_charset($con,'utf8');
mysqli_select_db($con, "resource_sharing");

$time = time();
$lasttime = date('Y-m-d H:i:s', $time);
//echo $lasttime;

$sqlcheck = ("insert into download(downloader, resource, time) values('$uid', '$res', '$lasttime');" );
$runcheck = mysqli_query($con, $sqlcheck);
if($runcheck == TRUE)
{
    echo 0; //下载成功
}
else
{
    echo 1; //插入数据库失败
}
?>