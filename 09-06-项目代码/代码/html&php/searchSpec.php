<?php

$specName = $_POST['specname'];
//$specName = "林未";

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
//全字匹配
$sql=("select specialist.id as specID, specialist.name as specName, affiliation as institute, sum(cited) as cited, count(*) as workNum ".
    "from specialist, specialist_achievement, achievement, paper ".
    "where specialist.id=specialist_achievement.sid and specialist_achievement.aid=achievement.id and achievement.id=paper.id and specialist.name='$specName' ".
    "group by specialist.id ");
$runSQL=mysqli_query($con, $sql);
if($runSQL){
    while($row = mysqli_fetch_assoc($runSQL)){
        array_push($data, $row);
    }
}

//模糊匹配
$sql=("select specialist.id as specID, specialist.name as specName, affiliation as institute, sum(cited) as cited, count(*) as workNum ".
    "from specialist, specialist_achievement, achievement, paper ".
    "where specialist.id=specialist_achievement.sid and specialist_achievement.aid=achievement.id and achievement.id=paper.id and specialist.name<>'$specName' and locate('$specName', specialist.name)>0 ".
    "group by specialist.id ");
$runSQL=mysqli_query($con, $sql);
if($runSQL){
    while($row = mysqli_fetch_assoc($runSQL)){
        array_push($data, $row);
    }
}


$sql=("select id as specID, name as specName, affiliation as institute from specialist where name='$specName'");
$runSQL=mysqli_query($con, $sql);
$len=count($data);
if($runSQL){
    while ($row = mysqli_fetch_assoc($runSQL)){
        $ok=0;
        for($i=0; $i<$len; $i++){
            if($data[$i]["specID"]==$row["specID"]){
                $ok=1;
                break;
            }
        }
        if($ok==0) {
            $row["workNum"]="0";
            $row["cited"]="0";
            array_push($data, $row);
        }
    }
}

$sql=("select id as specID, name as specName, affiliation as institute from specialist where name<>'$specName' and  locate('$specName', specialist.name)>0 ");
$runSQL=mysqli_query($con, $sql);
$len=count($data);
if($runSQL){
    while ($row = mysqli_fetch_assoc($runSQL)){
        $ok=0;
        for($i=0; $i<$len; $i++){
            if($data[$i]["specID"]==$row["specID"]){
                $ok=1;
                break;
            }
        }
        if($ok==0) {
            $row["workNum"]="0";
            $row["cited"]="0";
            array_push($data, $row);
        }
    }
}

$len=count($data);
//头像URL设置
for ($i=0; $i<$len; $i++){
    $tmp=$data[$i]['specID'];
    $avatorSQL = ("select avator from user where expert='$tmp'");
    $runAvatorSQL = mysqli_query($con, $avatorSQL);
    if($runAvatorSQL){
        $tmp = mysqli_fetch_assoc($runAvatorSQL);
        if($tmp["avator"]){
            $data[$i]['avator'] = $tmp["avator"];
        } else {
            $data[$i]['avator'] = "http://www.zdoubleleaves.cn/avator/default.jpg";
        }
    } else {
        $data[$i]['avator'] = "http://www.zdoubleleaves.cn/avator/default.jpg";
    }
}
//echo count($data);
$json = json_encode($data);
echo $json;
// var_dump($data);
//echo $data;
