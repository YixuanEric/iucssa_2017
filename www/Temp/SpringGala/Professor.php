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
	$attend = str_replace("'","''",$_POST['attend']);
  $family = str_replace("'","''",$_POST['family']);

  if($attend == "No"){
    $family = "0";
  }


	$sql="SELECT count(*) FROM SpringGalaProfessor where email='".$email."';";
	$stmt = $conn->prepare($sql);
  $stmt->execute();
	$result=$stmt->fetchall();
	if($result[0][0]>=1){
		$conn1 = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass);
    $conn1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql1="UPDATE SpringGalaProfessor SET lname='".$lname."',fname='".$fname."', attend='".$attend."', accompanion='".$family."', time=now() WHERE email='".$email."';";
		$stmt1 = $conn1->prepare($sql1);
		$stmt1->execute();
	} else {
    $conn2 = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass);
    $conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql2="INSERT INTO SpringGalaProfessor (fname,lname,email,attend,accompanion,time) VALUES('".$fname."','".$lname."', '".$email."', '".$attend."', '".$family."',now());";
		$stmt2 = $conn2->prepare($sql2);
		$stmt2->execute();
	}

	echo '<script>alert("You have complete the survey. Thank you for your help! -IUCSSA");</script>';
  echo '<center><span style="font-size: 1.5em;">You have complete the survey.</span></center>';
  echo '<center><span style="font-size: 1.5em;">Thank you for your help!</span></center>';
  echo '<center><span style="font-size: 1.5em;"> -IUCSSA</span></center>';
  die();
} catch (PDOException $e) {

	echo '<center>Unknown Error! Please try again later! </center>';
	echo $e;
  die();
}

?>
</body>
</html>
