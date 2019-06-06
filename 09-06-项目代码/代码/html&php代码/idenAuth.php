<?php

//参数：file1是正面，file2是反面
//userID是一个整数

$userID=$_POST["UID"];
// $userID = 199;

$name = password_hash($userID,PASSWORD_DEFAULT);

function trimall($str){
    $qian=array(" ","　","\t","\n","\r","\\","/");
    return str_replace($qian, '', $str);
}
$name = trimall($name);

$text=$name.'111.png';

if($_FILES["file1"]["error"])
{
    //echo $_FILES["file1"]["error"];
    echo 0;
}
else
{
    if(($_FILES["file1"]["type"]=="image/png"||$_FILES["file1"]["type"]=="image/jpeg"||$_FILES["file2"]["type"]=="image/pjpeg")&&$_FILES["file1"]["size"]<1024000)
    {
        //防止文件名重复
        $filename ="./IDimg/".$text;
        //转码，把utf-8转成gb2312,返回转换后的字符串， 或者在失败时返回 FALSE。
        $filename =iconv("UTF-8","gb2312",$filename);
        //保存文件,   move_uploaded_file 将上传的文件移动到新位置
        move_uploaded_file($_FILES["file1"]["tmp_name"],$filename);//将临时地址移动到指定地址


        //连接数据库更新头像的文件名
        $image_url="http://www.zdoubleleaves.cn/rsp/IDimg/".$text;
        $con = mysqli_connect("123.206.68.192","mysqluser", "16211621","test");
        mysqli_query($con,"UPDATE user SET identity1= '$image_url'WHERE id='$userID'");
        mysqli_close($con);


    }
    else
    {
        //echo"文件过大或类型不对";
        echo 0;
    }


}


$text1=$name.'222.png';

if($_FILES["file2"]["error"])
{
    //echo $_FILES["file2"]["error"];
    echo 0;
}
else
{
    //没有出错
    //加限制条件
    //判断上传文件类型为png或jpg且大小不超过1024000B
    if(($_FILES["file2"]["type"]=="image/png"||$_FILES["file2"]["type"]=="image/jpeg"||$_FILES["file2"]["type"]=="image/pjpeg")&&$_FILES["file2"]["size"]<1024000)
    {
        //防止文件名重复
        $filename1 ="./IDimg/".$text1;
        //转码，把utf-8转成gb2312,返回转换后的字符串， 或者在失败时返回 FALSE。
        $filename1 =iconv("UTF-8","gb2312",$filename1);
        //保存文件,   move_uploaded_file 将上传的文件移动到新位置
        move_uploaded_file($_FILES["file2"]["tmp_name"],$filename1);//将临时地址移动到指定地址


        //连接数据库更新头像的文件名
        $image_url="http://www.zdoubleleaves.cn/rsp/IDimg/".$text1;
        $con = mysqli_connect("123.206.68.192","mysqluser", "16211621","test");
        mysqli_query($con,"UPDATE user SET identity2= '$image_url' WHERE id='$userID';");
        
        $ttime = date("Y-m-d H:i:s",time());
        mysqli_query($con,"INSERT into  certification (applicant,time) VALUES ('$userID','$ttime');");

        mysqli_close($con);

        echo 1;
    }
    else
    {
        //echo"文件过大类型不对";
        echo 0;
    }


}