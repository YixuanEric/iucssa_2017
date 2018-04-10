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
	$cellphone=str_replace("'","''",$_POST['cellphone']);
	$email=str_replace("'","''",$_POST['email']);
	$year=str_replace("'","''",$_POST['year']);
	
	if($name==""||$cellphone==""||$email==""){
		return;
	}
	$sql1 = "Select * From shiguan;";
	$stmt1 = $conn->prepare($sql1);
	$stmt1->execute();
	$result1 = $stmt1->fetchall();
	if (count($result1)>200){
		echo '<script>alert("抱歉，该讲座已满员。IUCSSA感谢您的大力支持！");</script><center><span style="font-size: 1.5em;">抱歉，该讲座已满员。IUCSSA感谢您的大力支持！</span></center>';
	} else {
		$conn1 = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass);
    	$conn1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql="INSERT INTO shiguan (id,name,email,cellphone,year,time)  VALUES( NUll,'".$name."', '".$email."', '".$cellphone."', '".$year."', now());";
		$stmt = $conn1->prepare($sql);
	    $stmt->execute();
		
		echo '<script>alert("您已完成报名。IUCSSA感谢您的大力支持！");</script><center><span style="font-size: 1.5em;">你已完成报名。IUCSSA感谢您的大力支持！</span></center>';
	}
	
} catch (PDOException $e) {
	
	echo '<center>发生未知错误请稍后重试</center>';
	echo $e;
    die();
}
	
?>
</body>
</html>