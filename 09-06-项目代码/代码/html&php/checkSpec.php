<?php

$SID=$_POST['SID'];
$UID=$_POST['UID'];

// $SID=2;

$con=@new mysqli("123.206.68.192", "mysqluser", "16211621");
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
if($runSQL){
    while($row = mysqli_fetch_assoc($runSQL)){
        array_push($data, $row);
    }
}

//cited, workNum
$sql=("select sum(cited) as cited, count(*) as workNum from specialist, specialist_achievement, achievement, paper ".
    "where specialist.id=specialist_achievement.sid and specialist_achievement.aid=achievement.id and achievement.id=paper.id and specialist.id='$SID'".
    "group by specialist.id ");
$runSQL=mysqli_query($con, $sql);
if($runSQL){
    while($row = mysqli_fetch_assoc($runSQL)){
        array_push($data, $row);
    }
}


//journalNum
$sql=("select count(*) as journalNum from specialist, specialist_achievement, achievement, paper ".
    "where specialist.id=specialist_achievement.sid and specialist_achievement.aid=achievement.id and achievement.id=paper.id and specialist.id='$SID' and paper.database='期刊' ".
    "group by specialist.id ");
$runSQL=mysqli_query($con, $sql);
if($runSQL){
    $ok=0;
    while($row = mysqli_fetch_assoc($runSQL)){
        $ok=1;
        array_push($data, $row);
    }
    if($ok==0){
        array_push($data, array("journalNum"=>"0"));
    }
} else {
    array_push($data, array("journalNum"=>"0"));
}

//sessionNum
$sql=("select count(*) as sessionNum from specialist, specialist_achievement, achievement, paper ".
    "where specialist.id=specialist_achievement.sid and specialist_achievement.aid=achievement.id and achievement.id=paper.id and specialist.id='$SID' and paper.database='会议' ".
    "group by specialist.id ");
$runSQL=mysqli_query($con, $sql);
if($runSQL){
    $ok=0;
    while($row = mysqli_fetch_assoc($runSQL)){
        $ok=1;
        array_push($data, $row);
    }
    if($ok==0) {
        array_push($data, array("sessionNum"=>"0"));
    }
} else {
    array_push($data, array("sessionNum"=>"0"));
}

//zhuanzhuNum
$sql=("select count(*) as zhuanzhuNum from specialist, specialist_achievement, achievement, paper ".
    "where specialist.id=specialist_achievement.sid and specialist_achievement.aid=achievement.id and achievement.id=paper.id and specialist.id='$SID' and paper.database='专著' ".
    "group by specialist.id ");
$runSQL=mysqli_query($con, $sql);
if($runSQL){
    $ok=0;
    while($row = mysqli_fetch_assoc($runSQL)){
        $ok=1;
        array_push($data, $row);
    }
    if($ok==0){
        array_push($data, array("zhuanzhuNum"=>"0"));
    }
} else {
    array_push($data, array("zhuanzhuNum"=>"0"));
}

//elseNum
$sql=("select count(*) as elseNum from specialist, specialist_achievement, achievement, paper ".
    "where specialist.id=specialist_achievement.sid and specialist_achievement.aid=achievement.id and achievement.id=paper.id andspecialist.id='$SID' and paper.database<>'期刊' and paper.database<>'会议' and paper.database<>'专著' ".
    "group by specialist.id ");
$runSQL=mysqli_query($con, $sql);
if($runSQL){
    $ok=0;
    while($row = mysqli_fetch_assoc($runSQL)){
        $ok=1;
        array_push($data, $row);
    }
    if($ok==0){
        array_push($data, array("elseNum"=>"0"));
    }
} else {
    array_push($data, array("elseNum"=>"0"));
}

$json = json_encode($data);
echo($json);
//var_dump($json);
//echo($json);

//$utf8 = @preg_replace("/\\\u([0-9a-f]{4})/ie", "iconv('UTF-16BE', 'UTF-8', pack('H4','\\1'))", $json);
//echo $utf8;
