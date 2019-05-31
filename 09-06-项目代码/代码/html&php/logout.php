<?php
$uid = $_POST['userId'];
//$uid = 4;
$con=@new mysqli("123.206.68.192", "mysqluser", "16211621");
//如果连接错误
if(mysqli_connect_errno()){
    echo 3; //数据库连接失败
    $con=null;
    exit;
}
mysqli_set_charset($con,'utf8');
mysqli_select_db($con, "test");
$sqlcheck = ("select islogin from user where id = '$uid';" );
$runcheck = mysqli_query($con, $sqlcheck);
$resultcheck = mysqli_fetch_array($runcheck);
if($resultcheck[0] == 0)
{
    echo 1; //该用户未登录
}
else
{
    $sql1 = ("update user set islogin = 0 where id = '$uid';" );
    $run1 = mysqli_query($con, $sql1);
    if($run1 == TRUE)
    {
        echo 0; //退出登录成功
    }
    else
    {
        echo 2; //修改数据库字段失败
    }
}
?>