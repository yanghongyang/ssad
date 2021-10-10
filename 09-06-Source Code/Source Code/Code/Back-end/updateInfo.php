<?php

$id = $_POST['id'];
$nickname = $_POST['nickname'];
$email = $_POST['email'];
$profile = $_POST['profile'];

//$id = 7;
//$nickname = "张三";
//$email = "1@buaa.edu.cn";
//$profile = "好！";

$con=@new mysqli("123.206.68.192", "mysqluser", "16211621");
//如果连接错误
if(mysqli_connect_errno()){
    echo 2; //数据库连接失败
    $con=null;
    exit;
}
mysqli_set_charset($con,'utf8');
mysqli_select_db($con, "resource_sharing");

//$sqlcheck = ("update user set nickname = '$nickname' and email = '$email' and profile = '$profile' where id = '$id';" );
$sqlcheck = ("update user set nickname = '$nickname', email = '$email', profile = '$profile' where id = '$id';" );
$runcheck = mysqli_query($con, $sqlcheck);
if($runcheck == TRUE)
{
    echo 0; //成功
}
else
{
    echo 1; //失败
}
?>