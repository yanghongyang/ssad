<?php
date_default_timezone_set ('Asia/Shanghai');
$PID=$_POST["PID"];
$UID=$_POST["UID"];
// $PID=1;
// $UID=1;
$con=@new mysqli("123.206.68.192", "mysqluser", "16211621");
//如果连接错误
if(mysqli_connect_errno()){
    echo "连接失败"; //数据库连接失败
    $con=null;
    exit;
}
mysqli_set_charset($con,'utf8');
mysqli_select_db($con, "resource_sharing");

$sql = ("select * from collection where uid='$UID' and pid='$PID'");
$runSQL = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($runSQL);
if($row == NULL){
    $sql=("insert into collection(uid, pid) values ('$UID', '$PID')");
    $runSQL=mysqli_query($con, $sql);
    if($runSQL){
        echo "收藏成功";
    } else {
        echo "收藏失败";
    }
} else {
    $sql=("delete from collection where uid='$UID' and pid='$PID'");
        $runSQL=mysqli_query($con, $sql);
        if($runSQL){
            echo "取消收藏成功";
        } else {
            echo "取消收藏成功";
        }
}

