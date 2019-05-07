<?php
//$contents=$_POST['contents'];
//$UID=$_POST['userID'];

$contents="contents";
$UID=1;
$con=@new mysqli("123.206.68.192", "mysqluser", "16211621");
//如果连接错误
if(mysqli_connect_errno()){
    echo 3; //数据库连接失败
    $con=null;
    exit;
}
mysqli_set_charset($con,'utf8');
mysqli_select_db($con, "test");

$time=date('Y-m-d H:i:s', time());
$searchSQL=("select achievement.id, title, abstract, source1, source2, source3, source4, time, cited from achievement, paper".
    " where achievement.id=paper.id and (LOCATE('$contents', abstract)>0 or LOCATE('$contents', title)>0)");
$insertSQL=("insert into search(searcher, term, time) values('$UID', '$contents', '$time')");
$runSerach = mysqli_query($con, $searchSQL);
$runInsert = mysqli_query($con, $insertSQL);
$data = array();
while ($row = mysqli_fetch_assoc($runSerach)) {
    $data[] = $row;
}
$json = json_encode($data);
$utf8 = @preg_replace("/\\\u([0-9a-f]{4})/ie", "iconv('UTF-16BE', 'UTF-8', pack('H4','\\1'))", $json);
echo $utf8;
if($runInsert==TRUE){
    echo "插入成功";
} else {
    echo "插入失败";
}