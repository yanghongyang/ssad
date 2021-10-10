<?php
$cid = $_POST['CID'];
$uid = $_POST['userID'];

//$cid = 2;
//$uid = 3;

$con=@new mysqli("123.206.68.192", "mysqluser", "16211621");
//如果连接错误
if(mysqli_connect_errno()){
    echo 2; //数据库连接失败
    $con=null;
    exit;
}
mysqli_set_charset($con,'utf8');
mysqli_select_db($con, "test");

$sqlcheck = ("delete from comment where id = '$cid' and commentator = '$uid';");
$runcheck = mysqli_query($con, $sqlcheck);
if($runcheck == TRUE)
{
    echo 0; //删除成功
}
else
{
    echo 1; //删除失败
}
?>