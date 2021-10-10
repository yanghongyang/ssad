<?php
date_default_timezone_set ('Asia/Shanghai');
$uname = $_POST['nickname'];
//$pro = $_POST['profile'];
//$ema = $_POST['email'];
$pass = $_POST['password'];

$pro = "";
$ema = "";

$con=@new mysqli("123.206.68.192", "mysqluser", "16211621");
//如果连接错误
if(mysqli_connect_errno()){
    echo 3; //数据库连接失败
    $con=null;
    exit;
}
mysqli_set_charset($con,'utf8');
mysqli_select_db($con, "resource_sharing");
$sqlcheck = ("select count(*) from user where nickname = '$uname';" );
$runcheck = mysqli_query($con, $sqlcheck);
$resultcheck = mysqli_fetch_array($runcheck);
if($resultcheck[0] > 0)
{
    echo 1; //该用户名已存在
}
else
{
    $sql = ("insert into user(nickname, profile, email, password, type) values('$uname', '$pro', '$ema', '$pass', 0);" );
    $run = mysqli_query($con, $sql);
    if($run == TRUE)
    {
        echo 0; //注册成功
    }
    else
    {
        echo 2; //插入数据库失败
    }
}
?>