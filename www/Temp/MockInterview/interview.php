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
	$major=str_replace("'","''",$_POST['major']);
	$interest=str_replace("'","''",$_POST['interest']);
	$year=str_replace("'","''",$_POST['year']);
	
	$confirmationID="placeholder";
	
	$sql="SELECT count(*) FROM MockInterview where email='".$email."';";
	$stmt = $conn->prepare($sql);
    $stmt->execute();
	$result=$stmt->fetchall();
	if($result[0][0]>=1){
		$conn1 = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass);
    	$conn1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql1="UPDATE MockInterview SET name='".$name."',major='".$major."', interest='".$interest."', year='".$year."', time=now() WHERE email='".$email."';";
		$stmt1 = $conn1->prepare($sql1);
		$stmt1->execute();
	} else {
		$conn2 = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass);
    	$conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql2="INSERT INTO MockInterview (name,email,major,interest,year,time)  VALUES('".$name."', '".$email."', '".$major."', '".$interest."','".$year."',now());";
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