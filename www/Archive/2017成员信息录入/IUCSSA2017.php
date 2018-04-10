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
	$department=str_replace("'","''",$_POST['department']);
	$standing=str_replace("'","''",$_POST['standing']);
	$email=str_replace("'","''",$_POST['email']);
	$bday=str_replace("'","''",$_POST['bday']);
	echo '<script>console.log("'.$bday.'");</script>';
	if($name==""||$cellphone==""||$department==""||$standing==""||$email==""){
		return;
	}
	$sql="SELECT count(*) FROM Members where name='".$name."';";
	$stmt = $conn->prepare($sql);
    $stmt->execute();
	$result=$stmt->fetchall();
	//$result=json_encode($result);
	if($result[0][0]==1){
		$conn1 = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass);
    	$conn1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql1="UPDATE Members SET cellphone='".$cellphone."', department='".$department."', standing='".$standing."', email='".$email."', bday='".$bday."' where name='".$name."';";
		$stmt1 = $conn1->prepare($sql1);
		$stmt1->execute();
	} else {
		$conn2 = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass);
    	$conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql2="INSERT INTO Members (name,email,standing,cellphone,bday,department) VALUES('".$name."', '".$email."', '".$standing."', '".$cellphone."', '".$bday."', '".$department."');";
		$stmt2 = $conn2->prepare($sql2);
		$stmt2->execute();
	}
	
	echo '<script>alert("IUCSSA感谢您的大力支持与参与，您的信息已被录入，祝您好运！");</script><center>IUCSSA感谢您的大力支持与参与，您的信息已被录入，祝您好运！</center>';
	
} catch (PDOException $e) {
	
	echo '<script>alert("发生了未知错误，请稍等片刻再重新提交！");</script><center>发生了未知错误，请稍等片刻再重新提交！</center>';
	
    die();
}
	
?>
</body>
</html>