<?php
$uid = $_POST['userId'];
$con = $_POST['content'];
$pid = $_POST['paperID'];

//$uid = 3;
//$cont = "好嗨哟！";
//$pid = 1;

$con=@new mysqli("123.206.68.192", "mysqluser", "16211621");
//如果连接错误
if(mysqli_connect_errno()){
    echo 2; //数据库连接失败
    $con=null;
    exit;
}
mysqli_set_charset($con,'utf8');
mysqli_select_db($con, "test");

$time = time();
$lasttime = date('Y-m-d H:i:s', $time);
//echo $lasttime;

$sqlcheck = ("insert into comment(resource, commentator, content, time) values('$pid', '$uid', '$cont', '$lasttime');" );
$runcheck = mysqli_query($con, $sqlcheck);
if($runcheck == TRUE)
{
    echo 0; //评论成功
}
else
{
    echo 1; //插入数据库失败
}
?>