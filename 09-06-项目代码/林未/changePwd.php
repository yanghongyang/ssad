<?php
//$uname = $_POST['userName'];
//$pass = $_POST['newPwd'];

$uname = "abc";
$pass = "hhhhh";

$con=@new mysqli("123.206.68.192", "mysqluser", "16211621");
//如果连接错误
if(mysqli_connect_errno()){
    echo 3; //数据库连接失败
    $con=null;
    exit;
}
mysqli_set_charset($con,'utf8');
mysqli_select_db($con, "test");

$sqlcheck = ("select count(*) from user where nickname = '$uname';" );
$runcheck = mysqli_query($con, $sqlcheck);
$resultcheck = mysqli_fetch_array($runcheck);
if($resultcheck[0] = 0)
{
    echo 1; //该用户名不存在
}
else
{
    $sql = ("update user set password = '$pass' where nickname = '$uname';" );
    $run = mysqli_query($con, $sql);
    if($run == TRUE)
    {
        echo 0; //重置成功
    }
    else
    {
        echo 2; //修改数据库失败
    }
}
?>