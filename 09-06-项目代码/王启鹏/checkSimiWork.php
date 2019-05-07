<?php
//$PID=$_POST['paperID'];
$PID=1;
$con=@new mysqli("123.206.68.192", "mysqluser", "16211621");
//如果连接错误
if(mysqli_connect_errno()){
    echo 3; //数据库连接失败
    $con=null;
    exit;
}
mysqli_set_charset($con,'utf8');
mysqli_select_db($con, "test");

$checkTargetSQL=("select title, keyword from achievement, paper where achievement.id=paper.id and achievement.id='$PID'");
$runCheckTarget=mysqli_query($con, $checkTargetSQL);
$target = array(mysqli_fetch_assoc($runCheckTarget));
$target=array($target[0]["title"], $target[0]["keyword"]);

$checkSimiSQL=("select achievement.id, title, abstract, source1, source2, source3, source4, time, cited from achievement, paper where achievement.id=paper.id and (title='$target[0]' or keyword='$target[1]')");
$runCheckSimi=mysqli_query($con, $runCheckSimi);
$data=array();
while($row=mysqli_fetch_assoc($runCheckSimi)){
    $data[]=$row;
}
$json = json_encode($data);
$utf8 = @preg_replace("/\\\u([0-9a-f]{4})/ie", "iconv('UTF-16BE', 'UTF-8', pack('H4','\\1'))", $json);
echo $utf8;
