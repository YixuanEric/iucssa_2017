<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title></title>
</head>

<body>
<?php

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
	$dorm=str_replace("'","''",$_POST['dorm']);
	
	if($dorm == "other"){
		$other = "";
	} else {
		$other=str_replace("'","''",$_POST['other']);
	}
	
	$time=str_replace("'","''",$_POST['pickuptime']);
	
	
	$sql="SELECT count(*) FROM fields where email='".$email."';";
	$stmt = $conn->prepare($sql);
    $stmt->execute();
	$result=$stmt->fetchall();
	if($result[0][0]>=1){
		$conn1 = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass);
    	$conn1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql1="UPDATE fields SET name='".$name."',cellphone='".$cellphone."', dorm='".$dorm."', other='".$other."', pickuptime='".$time."',time=now() WHERE email='".$email."';";
		$stmt1 = $conn1->prepare($sql1);
		$stmt1->execute();
	} else {
		$conn2 = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass);
    	$conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql2="INSERT INTO fields (name,email,cellphone,dorm,other,pickuptime,time)  VALUES('".$name."', '".$email."', '".$cellphone."', '".$dorm."','".$other."','".$time."',now());";
		$confirmationID = $stmt2 = $conn2->prepare($sql2);
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