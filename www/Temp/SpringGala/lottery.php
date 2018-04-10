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


	$fname = str_replace("'","''",$_POST['fname']);
  $lname = str_replace("'","''",$_POST['lname']);
	$email = str_replace("'","''",$_POST['email']);
	$fiveDigit = str_replace("'","''",$_POST['fiveDigit']);
  $id = 0;

	$sql="SELECT count(*) FROM SpringGalaLottery where fname='".$fname."' AND lname='".$lname."' AND email='".$email."' AND fiveDigit='".$fiveDigit."';";
	$stmt = $conn->prepare($sql);
  $stmt->execute();
	$result=$stmt->fetchall();

	if($result[0][0]==0){
    $conn2 = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass);
    $conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql2="INSERT INTO SpringGalaLottery (fname,lname,fiveDigit,code,email,time) VALUES('".$fname."','".$lname."', '".$fiveDigit."', Null, '".$email."',now());";
		$stmt2 = $conn2->prepare($sql2);
		$stmt2->execute();
  }
	$conn1 = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass);
  $conn1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql1="SELECT * FROM SpringGalaLottery where fname='".$fname."' AND lname='".$lname."' AND email='".$email."' AND fiveDigit='".$fiveDigit."';";
	$stmt1 = $conn1->prepare($sql1);
	$stmt1->execute();
  $result1 = $stmt1->fetchall();
  $id = $result1[0][3];


  echo '<center><span style="font-size: 1.5em;color: red;">注意！</span></center>';
  echo '<center><span style="font-size: 1.5em;">您已报名抽奖成功，请<span style="color:red;">截图</span>本页面并妥善保管作为领奖凭证。</span></center>';
  echo '<center><span style="font-size: 1.5em;">姓名：'.$lname." ".$fname.'</span></center>';
  echo '<center><span style="font-size: 1.5em;">学生证后5位：'.$fiveDigit.'</span></center>';
  echo '<center><span style="font-size: 1.5em;">邮箱：'.$email.'</span></center>';
  echo '<center><span style="font-size: 1.5em;">抽奖号码：</span><span style="font-size: 1.5em;color: red;">'.(string)$id.'</span></center>';
  echo '<center><span style="font-size: 1.5em;">IUCSSA</span></center>';
  die();

} catch (PDOException $e) {

	echo '<center>Unknown Error! Please try again later! </center>';
	echo $e;
  die();
}

?>
</body>
</html>
