    
<?php
$id = $_POST['id'];
//$id = 1;
$con=@new mysqli("123.206.68.192", "mysqluser", "16211621");
//如果连接错误
if(mysqli_connect_errno()){
    echo 2; //数据库连接失败
    $con=null;
    exit;
}
mysqli_set_charset($con,'utf8');
mysqli_select_db($con, "resource_sharing");
$sqlcheck = ("update certification set state = 1 where id = '$id';");
$runcheck = mysqli_query($con, $sqlcheck);
if($runcheck == TRUE)
{
    echo 0; //成功
}
else
{
    echo 1; //失败
}
?>