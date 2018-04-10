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

  if($_POST['fname'] == ''){
    die();
  }

	$fname = str_replace("'","''",$_POST['fname']);
  $lname = str_replace("'","''",$_POST['lname']);
	$email = str_replace("'","''",$_POST['email']);
	$role = str_replace("'","''",$_POST['attend']);
  $cell = str_replace("'","''",$_POST['cellphone']);
  $year = str_replace("'","''",$_POST['class']);
  $major = str_replace("'","''",$_POST['major']);
  if($role == 'audience'){
    $cell = 'N/A';
    $year = 'N/A';
    $major = 'N/A';
  }

	$sql="SELECT count(*) FROM SpringGalaJobFair where fname='".$fname."' AND lname='".$lname."' AND email='".$email."';";
	$stmt = $conn->prepare($sql);
  $stmt->execute();
	$result=$stmt->fetchall();

	if($result[0][0]==0){
    $conn2 = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass);
    $conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql2="INSERT INTO SpringGalaJobFair (fname,lname,email,attend,cellphone,year,major,code,time) VALUES('".$fname."','".$lname."', '".$email."','".$role."','".$cell."','".$year."','".$major."', Null,now());";
		$stmt2 = $conn2->prepare($sql2);
		$stmt2->execute();
  } else {
    $conn2 = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass);
    $conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql2="UPDATE SpringGalaJobFair Set attend='".$role."', cellphone='".$cell."', year='".$year."', major='".$major."', time=now() WHERE fname='".$fname."' AND lname='".$lname."' AND email='".$email."';";
		$stmt2 = $conn2->prepare($sql2);
		$stmt2->execute();
  }
	$conn1 = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass);
  $conn1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql1="SELECT * FROM SpringGalaJobFair where fname='".$fname."' AND lname='".$lname."' AND email='".$email."';";
	$stmt1 = $conn1->prepare($sql1);
	$stmt1->execute();
  $result1 = $stmt1->fetchall();
  $id = $result1[0][7];


  echo '<center><span style="font-size: 1.5em;color: red;">注意！</span></center>';
  echo '<center><span style="font-size: 1.5em;">您已报名非你莫属成功，请<span style="color:red;">截图</span>本页面并妥善保管作为凭证。</span></center>';
  echo '<center><span style="font-size: 1.5em;">姓名：'.$lname." ".$fname.'</span></center>';
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
