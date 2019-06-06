<?php
header("Content-Type:text/html;charset=UTF-8");
//content:搜索内容(人名)
$content=urlencode($_POST["content"]);

$url = 'http://123.206.68.192:8080/solr/new_core2/select?q=name:'.$content;


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url );
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER,0);
$output = curl_exec($ch);
$arr = json_decode($output, true);
//列表的长度
$len = count($arr['response']['docs']);
//echo $len;


$con=@new mysqli("123.206.68.192", "mysqluser", "16211621");
//如果连接错误
if(mysqli_connect_errno()){
    //echo 3; //数据库连接失败
    $con=null;
    exit;
}
mysqli_set_charset($con,'utf8');
mysqli_select_db($con, "resource_sharing");


$res = array();

for($i = 0;$i<$len;$i++)
{
    $tempID = $arr['response']['docs'][$i]['id'];
    //$tempID = (int)$tempID;

    $sqlcheck = ("SELECT * FROM specialist  WHERE id = '$tempID';" );

    $runcheck = mysqli_query($con, $sqlcheck);
    $data = array();
    while ($row = mysqli_fetch_assoc($runcheck)) {
        $res[] = $row;
    }

}


$json = str_replace("\\/", "/", json_encode($res,JSON_UNESCAPED_UNICODE));

curl_close($ch);

echo $json;