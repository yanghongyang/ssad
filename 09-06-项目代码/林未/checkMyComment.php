<?php
//$uid = $_POST['userID'];

$uid = 5;

$con=@new mysqli("123.206.68.192", "mysqluser", "16211621");
//如果连接错误
if(mysqli_connect_errno()){
    echo 3; //数据库连接失败
    $con=null;
    exit;
}
mysqli_set_charset($con,'utf8');
mysqli_select_db($con, "test");

$sqlcheck = ("select comment.id as CID, comment.time, content, title as paperName from achievement, comment where resource = achievement.id and commentator = '$uid';" );
$runcheck = mysqli_query($con, $sqlcheck);
$data = array();
while ($row = mysqli_fetch_assoc($runcheck)) {
    $data[] = $row;
}
$json = json_encode($data);
$utf8 = @preg_replace("/\\\u([0-9a-f]{4})/ie", "iconv('UTF-16BE', 'UTF-8', pack('H4','\\1'))", $json);
echo $utf8;
?>