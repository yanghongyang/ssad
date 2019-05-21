<?php
$pid = $_POST['paperID'];

//$pid = 1;

$con=@new mysqli("123.206.68.192", "mysqluser", "16211621");
//如果连接错误
if(mysqli_connect_errno()){
    echo "数据库连接失败"; //数据库连接失败
    $con=null;
    exit;
}
mysqli_set_charset($con,'utf8');
mysqli_select_db($con, "test");

$sqlcheck = ("select sid, name, specialist_achievement.order from specialist_achievement, specialist where sid = id and aid = '$pid' order by specialist_achievement.order;" );
$runcheck = mysqli_query($con, $sqlcheck);
$data = array();
while ($row = mysqli_fetch_assoc($runcheck)) {
    $data[] = $row;
}
$json = json_encode($data);
echo $json;
?>