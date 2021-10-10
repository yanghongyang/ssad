<?php

//$specName = $_POST['specname'];
$specName = "林未";

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
//, sum(cited) as cited, count(*) as workNum
$sql=("select specialist.id as specID, specialist.name as specName, affiliation as institute, sum(cited) as cited, count(*) as workNum ".
    "from specialist, specialist_achievement, achievement, paper ".
    "where specialist.id=specialist_achievement.sid and specialist_achievement.aid=achievement.id and achievement.id=paper.id and specialist.name='$specName'".
    "group by specialist.id ");
$runSQL=mysqli_query($con, $sql);
if($runSQL){
    while($row = mysqli_fetch_assoc($runSQL)){
        array_push($data, $row);
    }
    $len = count($data);
//    echo $len;
    for($i=0; $i<$len; $i++){
        $tmp=$data[$i]['specID'];
        $avatorSQL = ("select avator from user where user.expert='$tmp'");
        $runAvatorSQL = mysqli_query($con, $avatorSQL);
        if($runAvatorSQL){
            $tmp = mysqli_fetch_assoc($runAvatorSQL);
            $data[$i]['avator'] = $tmp["avator"];
        } else {
            $data[$i]['avator'] = "http://www.zdoubleleaves.cn/avator/default.jpg";
        }
    }
}
//var_dump($data);
$json = json_encode($data);
echo($json);
//var_dump($json);
//echo($json);

