<?php
//$EID=$_POST['expertID'];
$EID=2;
$con=@new mysqli("123.206.68.192", "mysqluser", "16211621");
//如果连接错误
if(mysqli_connect_errno()){
    echo "连接失败"; //数据库连接失败
    $con=null;
    exit;
}
mysqli_set_charset($con,'utf8');
mysqli_select_db($con, "test");
$SQL=("select avator from user, specialist where user.expert=specialist.id and specialist.id='$EID'");
$runSQL = mysqli_query($con, $SQL);
$data = array();
if($runSQL){
    while ($row = mysqli_fetch_assoc($runSQL)) {
        $data[] = $row;
    }
}
echo $data;