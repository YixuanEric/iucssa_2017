<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>template</title>
</head>

<body>
<?php
try {
        $host = 'mysql.iu.edu';
        $port = '4162'; //replace [PORT] with your port number
        $dbname = 'iucssa_database'; //replace [DATABASE] with your database name
        $user = 'root'; //replace [USER] with your MySQL user
        $pass = 'rge90jc'; //replace [PASSWORD] with your MySQL password

        $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $user, $pass);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


	//change from here. DO NOT CHANGING ABOVE THINGS


	//Insert query to insert form data into the artist table)
	$sql="INSERT INTO emaillist (email)
	VALUES ('".$_POST["email"]."')";
	$conn->exec($sql);
	readfile("wancheng.html");;
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br />";
        die();
    }
?>
</body>
</html>
