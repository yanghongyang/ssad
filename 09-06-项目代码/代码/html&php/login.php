<?php
$uname = $_POST['nickname'];
$pass = $_POST['password'];

//$uname = "abc12300011";
//$pass = "12356";

$con=@new mysqli("123.206.68.192", "mysqluser", "16211621");
//如果连接错误
if(mysqli_connect_errno()){
    $data['result'] = 5;
    $json = json_encode($data);
    echo $json; //数据库连接失败
    $con=null;
    exit;
}
mysqli_set_charset($con,'utf8');
mysqli_select_db($con, "test");

$data = array();

$sqlcheck = ("select count(*) from user where nickname = '$uname';" );
$runcheck = mysqli_query($con, $sqlcheck);
$resultcheck = mysqli_fetch_array($runcheck);
if($resultcheck[0] == 0)
{
    $data['result'] = 1;
    $json = json_encode($data);
    echo $json; //该用户不存在
}
else
{
    $sql1 = ("select count(*) from user where nickname = '$uname' and password = '$pass';" );
    $run1 = mysqli_query($con, $sql1);
    $result1 = mysqli_fetch_array($run1);
    if($result1[0] == 0)
    {
        $data['result'] = 2;
        $json = json_encode($data);
        echo $json; //用户密码不正确
    }
    else
    {
        $sql2 = ("select islogin from user where nickname = '$uname' and password = '$pass';");
        $run2 = mysqli_query($con, $sql2);
        $result2 = mysqli_fetch_array($run2);
        if($result2[0] == 1)
        {
            $data['result'] = 3;
            $json = json_encode($data);
            echo $json; //该用户已登录
        }
        else
        {
            $sql3 = ("update user set islogin = 1 where nickname = '$uname' and password = '$pass';");
            $run3 = mysqli_query($con, $sql3);
            if($run3 == TRUE)
            {
                $sql4 = ("select id, avator, type from user where nickname = '$uname' and password = '$pass';");
                $run4 = mysqli_query($con, $sql4);
                $data = mysqli_fetch_assoc($run4);
                $data['result'] = 0;
                $json = json_encode($data);
                echo $json;
            }
            else
            {
                $data['result'] = 4;
                $json = json_encode($data);
                echo $json; //更新数据库失败
            }
        }
    }
}
?>