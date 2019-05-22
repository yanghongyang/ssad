<?php
header("Content-Type:text/html;charset=UTF-8");
//两个参数：
//content:搜索内容
//type:搜索类型 【0 对于摘要检索；1 对于标题检索；2 全字段检索；3 摘要高亮； 4 标题高亮；5 全字段高亮】
$content=urlencode($_POST["content"]);
$type=$_POST["type"];
//$type = 3;
if($type == 0)
{
    $url = 'http://123.206.68.192:8080/solr/new_core/select?q=abstract:'.$content;
}
else if($type == 1)
{
    $url = 'http://123.206.68.192:8080/solr/new_core/select?q=title:'.$content;
}
else if($type == 2)
{
    $url = 'http://123.206.68.192:8080/solr/new_core/select?q='.$content;
}
else if($type == 3)
{
    //$url = 'http://123.206.68.192:8080/solr/new_core/select?q='.$content.'&hl=on&hl.fl=abstract&hl.simple.post='."&lt;/font&gt;"."&hl.simple.pre=&lt;font color=\'red\'&gt;";
    //echo $url;
    $url = 'http://123.206.68.192:8080/solr/new_core/select?q=abstract:'.$content.'&hl=on&hl.fl=abstract';
}
else if($type == 4)
{
    $url = 'http://123.206.68.192:8080/solr/new_core/select?q=title:'.$content.'&hl=on&hl.fl=title';
}
else if($type == 5)
{
    $url = 'http://123.206.68.192:8080/solr/new_core/select?q='.$content.'&hl=on&hl.fl=abstract,title';
}


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
mysqli_select_db($con, "test");

$j = 12;
//echo $arr['highlighting'][$j]['abstract'][0];

$res = array();

for($i = 0;$i<$len;$i++)
{
    $tempID = $arr['response']['docs'][$i]['id'];
    //$tempID = (int)$tempID;

    $sqlcheck = ("SELECT * FROM achievement,paper WHERE achievement.id = '$tempID'and achievement.id = paper.id;" );

    $runcheck = mysqli_query($con, $sqlcheck);
    $data = array();
    while ($row = mysqli_fetch_assoc($runcheck)) {
        $res[] = $row;
    }

}
//echo $res;
//echo $len;
if($type>=3)
{
    for($i = 0;$i<$len;$i++)
    {
        $tempID = $arr['response']['docs'][$i]['id'];
        //echo "i:".$tempID;
        if(isset($arr['highlighting'][$tempID]['abstract']))
        {
            $res[$i]['abstract'] = htmlentities(stripslashes($arr['highlighting'][$tempID]['abstract'][0]));
        }
        if(isset($arr['highlighting'][$tempID]['title']))
        {
            $res[$i]['title'] = htmlentities(stripslashes($arr['highlighting'][$tempID]['title'][0]));
        }
        $res[$i]['authList']="";
    }
}



$json = str_replace("\\/", "/", json_encode($res,JSON_UNESCAPED_UNICODE));

curl_close($ch);

echo $json;