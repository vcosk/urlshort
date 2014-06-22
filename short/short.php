<?php
$char_pool = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "o", "p", "q", "r", "s", "t", "u", "v", "w", "z", "y", "z", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "Z", "Y", "Z");

$cached_url_code = "";
if(isset($_COOKIE["url_shrt_code"])) {
	$cached_url_code = $_COOKIE["url_shrt_code"];
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["url_box"])) {
  	}
	else {
		$url_code = "";
		for($counter = 0; $counter < 7; $counter++) {
//			echo($counter . "asdasd<br />");
			$url_code = $url_code . $char_pool[rand(0,59)];
		}

		$con=mysqli_connect("localhost","","","");

		if (mysqli_connect_errno()) {
		  echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}

		$mysqltime = date ("Y-m-d H:i:s");

//		echo($mysqltime . "<br />");

		$link = $_POST["url_box"];
		if(stristr($link,"http://") or stristr($link,"https://")) {
		}
		else {
			$link = "http://".$link;
		}

		//A date and time combination, supported range is 1000-01-01 00:00:00 to 9999-12-31 23:59:59
		mysqli_query($con,"INSERT INTO `URL_MAP`(`CODE`, `LINK`, `COUNT`, `USER_ID`, `TS`) VALUES ('".$url_code."','".$link."',0,0,'".$mysqltime."')");

		mysqli_close($con);


		$display_url_code = "http://go-ahead.in/?".$url_code;

		$qr_code_url = "https://chart.googleapis.com/chart?cht=qr&chs=150x150&chld=H|0&chl=".$display_url_code ;

		//$qr_code_file = fopen($qr_code_url, "r");
		copy($qr_code_url, "./qrimg/".$url_code.".png");

		if(strlen($cached_url_code) == 0) {
			setcookie("url_shrt_code", $url_code);
		}
		else {
			setcookie("url_shrt_code", $url_code."||".$cached_url_code);
		}

		echo($display_url_code . "&nbsp;&nbsp;<img src='./qrimg/".$url_code.".png'/>&nbsp;&nbsp;".$link."<br /><br />");
	}
}

$codes = explode("||",$cached_url_code);
$code_count = 0;
$query_str = "";

if(count($codes) > 0) {

	$query_str = "SELECT * FROM `URL_MAP` WHERE `CODE` IN ('" . implode("','",$codes ) ."')";

	$con=mysqli_connect("localhost","","","");

	if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	$result = mysqli_query($con,$query_str );
	$link = "";
	$hit_count = 0;
	$code_count=0;
	while($row = mysqli_fetch_array($result)) {
		$link = $row['LINK'];
		$hit_count = $row['COUNT'];

		$display_url_code = "http://go-ahead.in/?".$codes[$code_count];
		echo($display_url_code . "&nbsp;&nbsp;<img src='./qrimg/$codes[$code_count].png'/>&nbsp;&nbsp;$link&nbsp;&nbsp;Count:&nbsp;$hit_count<br /><br />");
		$code_count = $code_count + 1;
	}

	mysqli_close($con);
	/*
	for($code_count=0; $code_count<count($codes);$code_count++) {
		$display_url_code = "http://go-ahead.in/?".$codes[$code_count];
		echo($display_url_code . "&nbsp;&nbsp;<img src='./qrimg/$codes[$code_count].png'/>&nbsp;&nbsp;$link&nbsp;&nbsp;Count:&nbsp;$hit_count<br /><br />");
	}
	*/
}
?>