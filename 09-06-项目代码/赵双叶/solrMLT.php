<?php
header("Content-Type:text/html;charset=UTF-8");
//1个参数：
//id:需要匹配的科技成果id
$id = $_POST["id"];

$url = 'http://123.206.68.192:8080/solr/new_core/select?&mlt=true&mlt.fl=abstract,cat&mlt.mindf=1&mlt.mintf=1&fl=id,score&q=id:'.$id;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url );
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER,0);
$output = curl_exec($ch);

$arr = json_decode($output, true);
//列表的长度
$len = count($arr['moreLikeThis'][$id]['docs']);
//echo $len;


$con=@new mysqli("123.206.68.192", "mysqluser", "16211621");
//如果连接错误
if(mysqli_connect_errno()){
    //echo 3; //数据库连接失败
    $con=null;
    exit;
}
mysqli_set_charset($con,'utf8');
mysqli_select_db($con, "test");


$res = array();

for($i = 0;$i<$len;$i++)
{
    $tempID = $arr['moreLikeThis'][$id]['docs'][$i]['id'];
    //$tempID = (int)$tempID;

    $sqlcheck = ("SELECT * FROM achievement WHERE id = '$tempID';" );

    $runcheck = mysqli_query($con, $sqlcheck);
    $data = array();
    while ($row = mysqli_fetch_assoc($runcheck)) {
        $res[] = $row;
    }

}


$json = str_replace("\\/", "/", json_encode($res,JSON_UNESCAPED_UNICODE));

curl_close($ch);

echo $json;