<?php
//$SID=$_POST['specID'];
$SID=1;

$con=@new mysqli("123.206.68.192", "mysqluser", "16211621");
//如果连接错误
if(mysqli_connect_errno()){
    echo "连接失败"; //数据库连接失败
    $con=null;
    exit;
}
mysqli_set_charset($con,'utf8');
mysqli_select_db($con, "test");
//专家信息
$sql=("select *  from specialist where id in ".
    "(select SA2.sid from specialist_achievement SA1, specialist_achievement SA2 where SA1.aid=SA2.aid and SA1.sid='$SID' and SA2.sid<>'$SID') ");
$runSQL=mysqli_query($con, $sql);
$data = array();
while ($row = mysqli_fetch_assoc($runSQL)) {
    $data[] = $row;
}
//合作次数
$sql=("select SA2.sid as sid, count(*) as coopNum from specialist_achievement SA1, specialist_achievement SA2 ".
    "where SA1.aid=SA2.aid and SA1.sid='$SID' and SA2.sid<>'$SID'".
    "group by SA2.sid");
$runSQL=mysqli_query($con, $sql);
while ($row = mysqli_fetch_assoc($runSQL)) {
    $data[] = $row;
}
//var_dump($data[3]);
$len=count($data);
$result=array();
for ($i=0; $i<$len/2; $i++){
    $result[$i]=array();
    $result[$i] = array_merge($result[$i], $data[$i]);
    for($j=$len/2; $j<$len; $j++) {
        if ($data[$j]["sid"] == $result[$i]["id"]){
            $result[$i] = array_merge($result[$i], $data[$j]);
            break;
        }
    }
}
array_multisort(array_column($result,'coopNum'),SORT_DESC,$result);
//var_dump($result);
$json = json_encode($data);
echo $json;
//$utf8 = @preg_replace("/\\\u([0-9a-f]{4})/ie", "iconv('UTF-16BE', 'UTF-8', pack('H4','\\1'))", $json);
//echo $utf8;

