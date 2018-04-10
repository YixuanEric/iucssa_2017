<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title></title>
</head>

<body>
<?php
/**
 * Created by PhpStorm.
 * User: jacoblin
 * Date: 2/11/17
 * Time: 14:20
 */
try {
    $host = 'mysql.iu.edu';
    $port = '4162'; //replace [PORT] with your port number
    $dbname = 'iucssa_28'; //replace [DATABASE] with your database name
    $user = 'root'; //replace [USER] with your MySQL user
    $pass = 'rge90jc'; //replace [PASSWORD] with your MySQL password

    $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	$name = str_replace("'","''",$_POST['name']);
	$email=str_replace("'","''",$_POST['email']);
	$firstpick=$_POST['position1'];
	$secondpick=$_POST['position2'];
	$cellphone=str_replace("'","''",$_POST['cellphone']);
	$weixinID=str_replace("'","''",$_POST['weixinID']);
	
	if($name==""||$cellphone==""||$firstpick==""||$secondpick==""||$email==""||$weixinID==""){
		return;
	}
	$sql="INSERT INTO wangzhePersonal (id,name,email,firstpick,secondpick,cellphone,weixinID,time) VALUES(NULL, '".$name."','".$email."','".$firstpick."','".$secondpick."','".$cellphone."','".$weixinID."',CURRENT_TIMESTAMP);";
	$stmt = $conn->prepare($sql);
    $stmt->execute();
	echo '<script>alert("IUCSSA感谢您的大力支持与参与，您的信息已被录入，祝您好运！");</script><center>IUCSSA感谢您的大力支持与参与，您的信息已被录入，祝您好运！</center>';
} catch (PDOException $e) {
	echo '<script>alert("发生了未知错误，请稍等片刻再重新提交！");</script><center>发生了未知错误，请稍等片刻再重新提交！</center>';
    die();
}
	
?>
</body>
</html>