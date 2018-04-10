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
    $dbname = 'iucssa_29'; //replace [DATABASE] with your database name
    $user = 'root'; //replace [USER] with your MySQL user
    $pass = 'rge90jc'; //replace [PASSWORD] with your MySQL password

    $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$name = str_replace("'","''",$_POST['name']);
	$email=str_replace("'","''",$_POST['email']);
	$cellphone=str_replace("'","''",$_POST['cellphone']);
	$major=str_replace("'", "''", $_POST['major']);
	$dept=str_replace("'", "''", $_POST['dept']);
  $username = strstr($email, '@', true);

	if($name==""||$cellphone==""||$email==""){
		return;
	}
	$sql="SELECT count(*) FROM 2018ZhaoXin where Email='".$email."';";
	$stmt = $conn->prepare($sql);
    $stmt->execute();
	$result=$stmt->fetchall();
	if($result[0][0]>=1){
		$conn1 = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass);
    	$conn1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    	$sql1="UPDATE 2018ZhaoXin SET Name='".$name."',Phone='".$cellphone."', Major='".$major."',Department='".$dept."', Timestamp=now() WHERE Email='".$email."';";
    	$stmt1 = $conn1->prepare($sql1);
		$stmt1->execute();
	} else {
		$conn2 = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass);
    	$conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$sql2="INSERT INTO 2018ZhaoXin (Name,Email,Phone,Major,Department,Timestamp)  VALUES( '".$name."', '".$email."', '".$cellphone."', '".$major."','".$dept."',now());";
		$stmt2 = $conn2->prepare($sql2);
		$stmt2->execute();
	}

  $target_dir = "uploads/";

  $target_file = $target_dir . $_POST['name']."_".$username."_".basename($_FILES["fileToUpload"]["name"]);

  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  // Check if image file is a actual image or fake image
  // if(isset($_POST["submit"])) {
  //     $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  //     if($check !== false) {
  //         echo "File is an image - " . $check["mime"] . ".";
  //         $uploadOk = 1;
  //     } else {
  //         echo "File is not an image.";
  //         $uploadOk = 0;
  //     }
  // }
  // Check if file already exists
  if (file_exists($target_file)) {
      echo "该文件已被上传";
      $uploadOk = 0;
  }
  // Check file size
  if ($_FILES["fileToUpload"]["size"] > 11000000) {
      echo "你的文件太大了，未上传成功，请上传10MB以下的文件";
      $uploadOk = 0;
  }
  // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
  && $imageFileType != "docx" && $imageFileType != "pdf") {
      echo "未上传文件或文件格式错误";
      $uploadOk = 0;
  }
  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
      echo "未上传文件";
  // if everything is ok, try to upload file
  } else {
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
          echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
      } else {
          echo "上传文件发生错误请联系学生会网站负责人";
      }
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
