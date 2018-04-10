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
	$overAge=str_replace("'","''",$_POST['overAge']);
	$ticket=str_replace("'","''",$_POST['ticketType']);
	$shuttle=str_replace("'","''",$_POST['shuttle']);
	
	$confirmationID="placeholder";
	
	if($name==""||$cellphone==""||$email==""){
		return;
	}
	$sql="SELECT count(*) FROM WineParty where email='".$email."';";
	$stmt = $conn->prepare($sql);
    $stmt->execute();
	$result=$stmt->fetchall();
	if($result[0][0]>=1){
		$conn1 = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass);
    	$conn1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql1="UPDATE WineParty SET name='".$name."',cellphone='".$cellphone."', overAge='".$overAge."', ticket='".$ticket."',shuttle='".$shuttle."' WHERE email='".$email."';";
		$stmt1 = $conn1->prepare($sql1);
		$stmt1->execute();
	} else {
		$conn2 = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass);
    	$conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql2="INSERT INTO WineParty (id,name,email,cellphone,overAge,ticket,shuttle,paid)  VALUES( NUll,'".$name."', '".$email."', '".$cellphone."', '".$overAge."','".$ticket."','".$shuttle."', 0);";
		$confirmationID = $stmt2 = $conn2->prepare($sql2);
		$stmt2->execute();
	}
	$conn3 = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass);
    $conn3->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql3="SELECT id FROM WineParty WHERE email='".$email."';";
	$stmt3 = $conn3->prepare($sql3);
	$stmt3->execute();
	$result3=$stmt3->fetchall();
	$confirmationID=$result3[0][0];
	
	$ticketPrice=0;
	if($ticket=="A"){
		$ticketPrice=10;
	}else {
		$ticketPrice=15;
	}
	$shuttlePrice = 0;
	if($shuttle=="D"){
		$shuttlePrice=10;
	} else if ($shuttle=="B"||$shuttle=="C"){
		$shuttlePrice=5;
	}
	
	$total = $shuttlePrice+$ticketPrice;
	echo '<script>alert("您已完成报名，请向fdiucssa@gmail.com的Chase账户支付 $'.$total.' 并在留言中注明唯一付款ID: '.$confirmationID.'。IUCSSA感谢您的大力支持与参与");</script><center><span style="font-size: 1.5em;">你已完成报名，请向fdiucssa@gmail.com的Chase账户支付 <span style="color:red"><b>$'.$total.'</b></span> 并在留言中注明唯一付款ID: <span style="color:red"><b>'.$confirmationID.'</b></span>。IUCSSA感谢您的大力支持与参与！</span></center>';
	
} catch (PDOException $e) {
	
	echo '<center>发生未知错误请稍后重试</center>';
	echo $e;
    die();
}
	
?>
</body>
</html>