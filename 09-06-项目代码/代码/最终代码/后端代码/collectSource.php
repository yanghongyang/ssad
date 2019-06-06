<?php
$UID=$_POST['userID'];
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
$SQL=("select achievement.id as id, title, abstract, paper.date as time, cited as citedNum from achievement, paper, collection ".
    " where achievement.id=paper.id and paper.id=collection.pid and collection.uid='$UID'");
$runSQL = mysqli_query($con, $SQL);
$data = array();
if($runSQL){
    while ($row = mysqli_fetch_assoc($runSQL)) {
        $data[] = $row;
    }
}
// var_dump($data);
$json = json_encode($data);
echo $json;
?>