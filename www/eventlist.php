<!doctype html>
<html>
<head>
    <title>IUCSSA Events</title>
    <!--bootstrap-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="bootstrap/js/jquery.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">
	
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="anti-cache.js"></script>
    <!--css-->
</head>

<body>

<div id="head"></div>
<script>
	$('#head').load('HeadNote.html');
</script>

<div class ="container">
<center><h2 class="title">Feature Events</h2></center>
<center>        
<div class="iconbox big4_desktop">

<div style="overflow-x:auto;">
  <table>
    <tr>
        
<?php
    
    $host = 'mysql.iu.edu';
    $port = '4162'; //replace [PORT] with your port number
    $dbname = 'iucssa_database'; //replace [DATABASE] with your database name
    $user = 'root'; //replace [USER] with your MySQL user
    $pass = 'rge90jc'; //replace [PASSWORD] with your MySQL password

    $conn1 = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass);
    $conn1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql1="Select * FROM feature_event_list;";
    $stmt1 = $conn1->prepare($sql1);
    $stmt1->execute();
    $result1 = $stmt1->fetchall();

    for($i = 0;$i<count($result1);$i++){
        //echo $result[$i][0];
        $title = $result1[$i][1];
        $abstraction = $result1[$i][2];
        $imgurl = $result1[$i][3];
        $pageurl = $result1[$i][4];
        echo "\r\n".'<th>';
        echo "\r\n".'<figure class="imghvr-push-up" style="background-color:#D14233">';
        echo "\r\n".'<img src="'.$imgurl.'" alt="example-picture" width="250px" height="350"/>';
        echo "\r\n".'<figcaption style="background-color:#D14233">';
        echo "\r\n".'<h3>'.$title.'</h3>';
        echo "\r\n".'<p> '.$abstraction.'</p>';
        echo "\r\n".'</figcaption><a href="'.$pageurl.'" target="_blank"></a>';
        echo "\r\n".'</figure>';
        echo "\r\n".'</th>';
    }
    echo '</tr>';
    echo '</table>';
    echo '</div></div>';


    echo '<!--Mobile Only Feature Events-->';
    echo '<div class="big4_mobile" style="overflow-x:scroll;">';
    echo '<div class="swiper-container">';
    echo '<div></div>';
    echo '<div class="swiper-wrapper">';


    for($i = 0;$i<count($result1);$i++){
        //echo $result[$i][0];
        $title = $result1[$i][1];
        $abstraction = $result1[$i][2];
        $imgurl = $result1[$i][3];
        $pageurl = $result1[$i][4];
        echo '<div class="swiper-slide"><a href="'.$pageurl.'" target="_blank"><img class="feature_Pic" src="'.$imgurl.'"></a></div>';
    }

?>

	</div>

	<div class="swiper-pagination"></div>
</div>

</div>
</center>
<center><h2 class="title">Recent Events</h2></center><div class="recentEvents">
<?php

try {
    $host = 'mysql.iu.edu';
    $port = '4162'; //replace [PORT] with your port number
    $dbname = 'iucssa_database'; //replace [DATABASE] with your database name
    $user = 'root'; //replace [USER] with your MySQL user
    $pass = 'rge90jc'; //replace [PASSWORD] with your MySQL password

    $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    //change from here. DO NOT CHANGING ABOVE THINGS


    //Insert query to insert form data into the artist table)
    $sql='SELECT * FROM event_list WHERE eventTitle<>"" AND eventAbstract<>"" AND imgURL<>"" AND webpageURL<>"" AND published>0 ORDER BY DATE DESC LIMIT 4 OFFSET '.(($_GET['page']-1)*4);
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchall();
    for($i = 0;$i<count($result);$i++){
        //echo $result[$i][0];
        $title = $result[$i][1];
        $abstraction = $result[$i][2];
        $imgurl = $result[$i][3];
        $pageurl = $result[$i][4];
        $date =$result[$i][5];
        echo "\r\n".'<div class="eventBlock row" style="text-align: left">';
        echo "\r\n".'<a href="'.$pageurl.'" target="_blank"><img src="'.$imgurl.'" class="eventPoster col-md-4"></a>';
        echo "\r\n".'<div class="eventBlockRightPane col-md-8">';
        echo "\r\n".'<div class="eventTitle"><a class="eventTitleLink" style="width: 100%;text-decoration:none;" href="'.$pageurl.'" target="_blank">';
        	echo $title.'</a><hr class="eventTitleAbstractSeparator "></div>';
		echo "\r\n".'<center><a href="'.$pageurl.'" target="_blank"><img class="eventPoster_Mobile" src="'.$imgurl.'"></a></center>';
		echo "\r\n".'<p class="eventAbstract" style="text-indent: 2.2em">'.$abstraction.'</p></a></div>';
		echo "\r\n".'<p class="eventDate col-md-8">';
		$month = substr((string)$result[$i][5],5,2);
		switch($month){
			case '01':
				echo 'Jan';
				break;
			case '02':
				echo 'Feb';
				break;
			case '03':
				echo 'Mar';
				break;
			case '04':
				echo 'Apr';
				break;
			case '05':
				echo 'May';
				break;
			case '06':
				echo 'Jun';
				break;
			case '07':
				echo 'Jul';
				break;
			case '08':
				echo 'Aug';
				break;
			case '09':
				echo 'Sep';
				break;
			case '10':
				echo 'Oct';
				break;
			case '11':
				echo 'Nov';
				break;
			case '12':
				echo 'Dec';
				break;
		}
		echo ' ';
		$day = substr((string)$result[$i][5],8,2);
		if((int)$day<10){
			echo substr($day,1,1);
		} else {
			echo $day;
		}
		echo ' ';
		echo '</p></div>';
		
		
	}
    echo '</div>';
    $stmt2=$conn->prepare('SELECT COUNT(*) FROM event_list WHERE eventTitle<>"" AND eventAbstract<>"" AND imgURL<>"" AND webpageURL<>"" AND published>0');     
    $stmt2->execute();
    $NumberOfRecords = $stmt2->fetchAll();
    $NumberOfPages=(ceil($NumberOfRecords[0][0]/4));
    
	echo '<center><nav><ul class="pagination page-blog">';
    
    if($_GET['page']>1){
    	echo '<li><a href="eventlist.php?page='.($_GET['page']-1).'" aria-label="Previous"><span aria-hidden="true">上一页<span></a></li>';
    }
    
    
    for($i = 1;$i<=$NumberOfPages;$i++){
    	echo '<li><a href="eventlist.php?page='.$i.'"';
		if($i==$_GET['page']){
			echo ' style="
						pointer-events: none;
						background-color:rgba(182,61,50,1.00);
						color: white;
						font-weight: bold;"';
		}
		echo '>'.$i.'</a></li>';
		
    }
	
    if($_GET['page']<$NumberOfPages){
    	echo '<li><a href="eventlist.php?page='.($_GET['page']+1).'" aria-label="Next"><span aria-hidden="true">下一页</span></a></li>';
    }
    
    echo '</ul></nav><center><br><br>';
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br />";
    die();
}
?>
<script>
	$(".pagination a").mouseover(function(){
		$(this).addClass("onhover");
	});
	$(".pagination a").mouseout(function(){
		$(this).removeClass("onhover");
	});
	</script>
</div>
<div id="foot"></div>
<script>
	$('#foot').load('FootNote.html');
</script>

<!--Customized CSS Must Be At The End-->
<link href="css/HeadNote.css" rel="stylesheet" type="text/css">
<link href="css/FootNote.css" rel="stylesheet" type="text/css">
<link href="css/universal.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="css/imagehover.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.4.1/css/swiper.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.4.1/js/swiper.min.js"></script>
<script>
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        paginationClickable: false,
        spaceBetween: 20,
        centeredSlides: true,
        autoplay: 2500,
        autoplayDisableOnInteraction: false
    });
</script>
<link href="css/eventlist.css" rel="stylesheet" type="text/css">
</body>
</html>
 