<?php
$userID=$_POST["userID"];
$title = $_POST["title"];
$abstract = $_POST["abstract"];
$author  = $_POST["author"];
$keywords”= $_POST["keywords"];
$database”= $_POST["database"];
$date”= $_POST["date"];
$cited”= $_POST["cited"];
$fund”= $_POST["fund"];
$classification”= $_POST["classification"];
$DOI”= $_POST["DOI"];
header("content-type:text/html;charset=utf-8");

//对于doi加密作为pdf命名
$name = password_hash($DOI,PASSWORD_DEFAULT).$_FILES["file"]["name"];

function trimall($str){
    $qian=array(" ","　","\t","\n","\r","\\","/");
    return str_replace($qian, '', $str);
}
$name = trimall($name);

if ($_FILES["file"]["error"])
{

}
else  if ((($_FILES["file"]["type"] == "application/pdf")))
{
     move_uploaded_file($_FILES["file"]["tmp_name"],
                "./pdf/".$name);

     $url="http://www.zdoubleleaves.cn/pdf/".$name;
     $con = mysqli_connect("123.206.68.192","mysqluser", "16211621","resource_sharing");
     mysqli_set_charset($con,"utf8");
     mysqli_query($con,"insert into achievement(title,abstract,time,url,type) values('$title', '$abstract', '$date','$url', 1);");
     $id = mysqli_insert_id($con);
    mysqli_query($con,"insert into paper(id,date,database,cited,keyword,doi)
      values('$id', '$date', '$database','$cited','$keywords','$DOI');");
     mysqli_close($con);

     $arr = array('paperID'=>$id,'URL'=>$url);
     $arr = json_encode($arr);
     echo $arr;


}
else
{

}
?>