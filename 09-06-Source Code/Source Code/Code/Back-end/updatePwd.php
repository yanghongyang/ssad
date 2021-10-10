<?php
$uid = $_POST['id'];
$pass = $_POST['pass'];

//$uid = 3;
//$pass = "hhhhh";

$con=@new mysqli("123.206.68.192", "mysqluser", "16211621");
//如果连接错误
if(mysqli_connect_errno()){
    echo 2; //数据库连接失败
    $con=null;
    exit;
}
mysqli_set_charset($con,'utf8');
mysqli_select_db($con, "resource_sharing");

$sql = ("update user set password = '$pass' where id = '$uid';" );
$run = mysqli_query($con, $sql);
if($run == TRUE)
{
    echo 0; //重置成功
}
else
{
    echo 1; //修改数据库失败
}
?>