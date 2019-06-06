<?php
$uid = $_POST['UID'];
$ema = $_POST['email'];

//$uid = 6;
//$ema = "123456@buaa.edu.cn";

$con=@new mysqli("123.206.68.192", "mysqluser", "16211621");
//如果连接错误
if(mysqli_connect_errno()){
    echo 2; //数据库连接失败
    $con=null;
    exit;
}
mysqli_set_charset($con,'utf8');
mysqli_select_db($con, "test");

$sqlcheck = ("update user set type = 1, email = '$ema' where id = '$uid';" );
$runcheck = mysqli_query($con, $sqlcheck);
if($runcheck == TRUE)
{
    echo 0; //修改成功
}
else
{
    echo 1; //修改数据库失败
}
?>