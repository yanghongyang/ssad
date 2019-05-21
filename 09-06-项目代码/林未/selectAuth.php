<?php
$uid = $_POST['id'];

//$uid = 5;

$con=@new mysqli("123.206.68.192", "mysqluser", "16211621");
//如果连接错误
if(mysqli_connect_errno()){
    echo "数据库连接失败"; //数据库连接失败
    $con=null;
    exit;
}
mysqli_set_charset($con,'utf8');
mysqli_select_db($con, "test");

$sqlcheck = ("select * from certification where applicant='$uid' order by time DESC" );
$runcheck = mysqli_query($con, $sqlcheck);
$data = array();
$row = mysqli_fetch_assoc($runcheck);
$json = json_encode($row);
echo $json;
?>