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
	
	$arr = array();
	$arr[0]=$_POST['teamName'];
	$arr[1]=$_POST['captainName'];
	$arr[2]=$_POST['captainCellphone'];
	$arr[3]=$_POST['weixinID'];
	$arr[4]=$_POST['Aname'];
	$arr[5]=$_POST['Acellphone'];
	$arr[6]=$_POST['Bname'];
	$arr[7]=$_POST['Bcellphone'];
	$arr[8]=$_POST['Cname'];
	$arr[9]=$_POST['Ccellphone'];
	$arr[10]=$_POST['Dname'];
	$arr[11]=$_POST['Dcellphone'];
	
	if($arr[0]==""){
			throw new Exception();
	}
	$tmp=str_replace("'","''",$arr[0]);
	for($i=1;$i<sizeof($arr);$i++){
		if($arr[$i]==""){
			throw new Exception();
		}
		$tmp = $tmp."','".$arr[$i];
	}
	
	$sql="INSERT INTO wangzheGroup (id,TeamName,CaptainName,CapCellphone,weixinID,Aname,Acell,Bname,Bcell,Cname,Ccell,Dname,Dcell,time) VALUES(NULL, '".$tmp."',CURRENT_TIMESTAMP);";
	$stmt = $conn->prepare($sql);
    $stmt->execute();
	echo '<script>alert("IUCSSA感谢您的大力支持与参与，您的信息已被录入，祝您好运！");</script><center>IUCSSA感谢您的大力支持与参与，您的信息已被录入，祝您好运！</center>';
} catch (Exception $e) {
	echo '<script>alert("发生了未知错误，请稍等片刻再重新提交！");</script><center>发生了未知错误，请稍等片刻再重新提交！</center>';
    die();
}
	
?>
</body>
</html>