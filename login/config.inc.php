<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<?php
 $server= "8.133.192.62";  //mysql服务器地址
 $user="root";         //登陆mysql的用户名
 $pass="Hccljq20031218!";   //登陆mysql的密码
 $db_name="inklounge";   //mysql中要操作的数据库名

$mysqli=mysqli_connect($server,$user,$pass, $db_name);
  mysqli_query($mysqli,"SET NAMES 'utf8'");
?>