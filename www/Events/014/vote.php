<?php
//Get IP Address
function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

//Find country code of ip address.
function iptocountry($ip)
{
  $numbers = preg_split( "/\./", $ip);    
 
  include("ip_files/".$numbers[0].".php");
  $code=($numbers[0] * 16777216) + ($numbers[1] * 65536) + ($numbers[2] * 256) + ($numbers[3]);
  foreach($ranges as $key => $value)
  {
    if($key<=$code)
    {
      if($ranges[$key][0]>=$code)
      {
        $country=$ranges[$key][1];break;
      }
    }
  }
 
  if ($country=="")
  {
    $country="unknown";
  }
 
  return $country;
}

$ip = getRealIpAddr();
$two_letter_country_code=iptocountry($ip);

if ($two_letter_country_code!="US"){

	//If the IP address is not from US,
  //send back 403 Forbidden response to HTML
  
  http_response_code(403);

} else {
  try {
    $host = 'mysql.iu.edu';
    $port = '4162'; //replace [PORT] with your port number
    $dbname = 'iucssa_28'; //replace [DATABASE] with your database name
    $user = 'root'; //replace [USER] with your MySQL user
    $pass = 'rge90jc'; //replace [PASSWORD] with your MySQL password

    //Vote increment
    $conn1 = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass);
    $conn1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql="";
  	
    if($_GET['action'] == "like"){
  		$sql="UPDATE GeShouDaSai_vote SET votes=votes+1 WHERE id =".$_GET['id'].";";
  	} else {
  		$sql="UPDATE GeShouDaSai_vote SET votes=votes-1 WHERE id =".$_GET['id'].";";
  	}
  	
  	$stmt = $conn1->prepare($sql);
    $stmt->execute();

    //record vote
  	$conn2 = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass);
    $conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
  	$sql = "INSERT INTO GeShouDaSai_record (id,ip,action,singerID,time) VALUES (NULL,'".$ip."','".$_GET['action']."',".$_GET['id'].",Null);";
      
  	$stmt = $conn2->prepare($sql);
    $stmt->execute();
    die();
  } catch (PDOException $e) {
  	echo $e;
  }
}
	
?>
