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
	$cellphone=str_replace("'","''",$_POST['cellphone']);
	
	$weixin=str_replace("'","''",$_POST['weixin']);
	$major=str_replace("'","''",$_POST['major']);

	$sql="SELECT count(*) FROM qipashuo where email='".$email."';";
	$stmt = $conn->prepare($sql);
    $stmt->execute();
	$result=$stmt->fetchall();
	$conn1 = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass);
	$conn1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	if($result[0][0]>=1){
		$sql1="UPDATE qipashuo SET name='".$name."',cellphone='".$cellphone."', weixin='".$weixin."',major='".$major."', timeStamp=now() WHERE email='".$email."';";
	} else {
		$sql1="INSERT INTO qipashuo (name,email,cellphone,weixin,major,timestamp)  VALUES( '".$name."', '".$email."', '".$cellphone."', '".$weixin."','".$major."',now());";
	}
	$stmt1 = $conn1->prepare($sql1);
		$stmt1->execute();
	
	echo '<script>alert("您已完成报名。IUCSSA感谢您的大力支持！");</script><center><span style="font-size: 1.5em;">你已完成报名。IUCSSA感谢您的大力支持！</span></center>';
	
} catch (PDOException $e) {
	
	echo '<center>发生未知错误请稍后重试</center>';
	echo $e;
    die();
}
	
?>
</body>
</html>