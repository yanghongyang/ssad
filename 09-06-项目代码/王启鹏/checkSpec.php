<?php

//$PID=$_POST['SID'];
//$UID=$_POST['UID'];
$SID = 1;
$UID = 1;
$con = @new mysqli("123.206.68.192", "mysqluser", "16211621");
//如果连接错误
if (mysqli_connect_errno()) {
    echo "连接失败"; //数据库连接失败
    $con = null;
    exit;
}
mysqli_set_charset($con, 'utf8');
mysqli_select_db($con, "test");

//name, affialition
$data=array();
$sql=("select specialist.name as name, specialist.affiliation as affiliation from specialist where specialist.id='$SID'");
$runSQL=mysqli_query($con, $sql);
array_push($data, mysqli_fetch_assoc($runSQL));

//cited, workNum
$sql=("select sum(cited) as cited, count(*) as workNum from specialist, specialist_achievement, achievement, paper ".
    "where specialist.id=specialist_achievement.sid and specialist_achievement.aid=achievement.id and achievement.id=paper.id ".
    "group by specialist.id having specialist.id='$SID'");
$runSQL=mysqli_query($con, $sql);
array_push($data, mysqli_fetch_assoc($runSQL));


//journalNum
$sql=("select count(*) as journalNum from specialist, specialist_achievement, achievement, paper ".
    "where specialist.id=specialist_achievement.sid and specialist_achievement.aid=achievement.id and achievement.id=paper.id and specialist.id='$SID' and paper.database='期刊' ".
    "group by specialist.id ");
$runSQL=mysqli_query($con, $sql);
array_push($data, mysqli_fetch_assoc($runSQL));


//sessionNum
$sql=("select count(*) as sessionNum from specialist, specialist_achievement, achievement, paper ".
    "where specialist.id=specialist_achievement.sid and specialist_achievement.aid=achievement.id and achievement.id=paper.id and specialist.id='$SID' and paper.database='会议' ".
    "group by specialist.id ");
$runSQL=mysqli_query($con, $sql);
array_push($data, mysqli_fetch_assoc($runSQL));

//zhuanzhuNum
$sql=("select count(*) as zhuanzhuNum from specialist, specialist_achievement, achievement, paper ".
    "where specialist.id=specialist_achievement.sid and specialist_achievement.aid=achievement.id and achievement.id=paper.id and specialist.id='$SID' and paper.database='专著' ".
    "group by specialist.id ");
$runSQL=mysqli_query($con, $sql);
array_push($data, mysqli_fetch_assoc($runSQL));

//elseNum
$sql=("select count(*) as elseNum from specialist, specialist_achievement, achievement, paper ".
    "where specialist.id=specialist_achievement.sid and specialist_achievement.aid=achievement.id and achievement.id=paper.id andspecialist.id='$SID' and paper.database<>'期刊' and paper.database<>'会议' and paper.database<>'专注' ".
    "group by specialist.id ");
$runSQL=mysqli_query($con, $sql);
array_push($data, mysqli_fetch_assoc($runSQL));

$json = json_encode($data);
$utf8 = @preg_replace("/\\\u([0-9a-f]{4})/ie", "iconv('UTF-16BE', 'UTF-8', pack('H4','\\1'))", $json);
echo $utf8;
