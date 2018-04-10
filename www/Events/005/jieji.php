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
	$email2=str_replace("'","''",$_POST['email2']);
	$weixin=str_replace("'","''",$_POST['weixin']);
	$cellphone=str_replace("'","''",$_POST['cellphone']);
	
	$flight=str_replace("'","''",$_POST['flight']);
	$date=str_replace("'","''",$_POST['date']);
	$time=str_replace("'","''",$_POST['time']);
	$EmergencyContact = str_replace("'","''",$_POST['EmergencyName']);
	$EmergencyNumber = str_replace("'","''",$_POST['EmergencyNumber']);
	$parent = str_replace("'","''",$_POST['parent']);
		
	if($name==""||$cellphone==""||$email==""){
		return;
	}
	$sql="SELECT count(*) FROM jieji where email='".$email."';";
	$stmt = $conn->prepare($sql);
    $stmt->execute();
	$result=$stmt->fetchall();
	if($result[0][0]>=1){
		$conn1 = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass);
    	$conn1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql1="UPDATE jieji SET name='".$name."',cellphone='".$cellphone."', email2='".$email2."',weixin='".$weixin."',cellphone='".$cellphone."', date='".$date."',time='".$time."', EmergencyContact='".$EmergencyContact."', EmergencyNumber='".$EmergencyNumber."', parent='".$parent."', timeStamp=now() WHERE email='".$email."';";
		$stmt1 = $conn1->prepare($sql1);
		$stmt1->execute();
	} else {
		$conn2 = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass);
    	$conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql2="INSERT INTO jieji (name,email,email2,weixin,cellphone,flight,date,time,EmergencyContact,EmergencyNumber,parent,timeStamp)  VALUES( '".$name."', '".$email."', '".$email2."', '".$weixin."', '".$cellphone."', '".$flight."','".$date."','".$time."','".$EmergencyContact."','".$EmergencyNumber."','".$parent."',now());";
		$stmt2 = $conn2->prepare($sql2);
		$stmt2->execute();
	}
	
	echo '<script>alert("您已完成报名。IUCSSA感谢您的大力支持！");</script><center><span style="font-size: 1.5em;">你已完成报名。IUCSSA感谢您的大力支持！</span></center>';
	
} catch (PDOException $e) {
	
	echo '<center>发生未知错误请稍后重试</center>';
	echo $e;
    die();
}
	
?>
</body>
</html>