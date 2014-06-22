<?php
	$param_count = count($_GET);
	if($param_count > 0) {
		$url_code = "";
		foreach ($_GET as $key=>$value) {
  			$url_code = $key;
  			break;
  		}

  		$con=mysqli_connect("localhost","","","");

		if (mysqli_connect_errno()) {
		  echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
//		echo($url_code."<br />");
		$query = "SELECT * FROM `URL_MAP` WHERE `CODE` = '".$url_code."'";
//		echo($query ."<br />");
		$result = mysqli_query($con,$query );
		$link = "";
		$hit_count=0;
		while($row = mysqli_fetch_array($result)) {
//			echo $row['CODE'] . " " . $row['LINK'] . "<br />";
			$link = $row['LINK'];
			$hit_count = $row['COUNT'];
		}
//		echo("$hit_count<br/>");
		$hit_count = $hit_count + 1;
//		echo("$hit_count<br/>");
		$mysqltime = date ("Y-m-d H:i:s");
//		echo("$mysqltime <br/>");
		$query_update = "UPDATE `URL_MAP` SET `COUNT`=".$hit_count.",`TS`='".$mysqltime."' WHERE `CODE`='".$url_code."'";
//		echo($query_update."<br />");
		mysqli_query($con,$query_update );

		mysqli_close($con);


		if(stristr($link,"http://") or stristr($link,"https://")) {
			header("Location: $link");
		}
		else {
			header("Location: http://$link");

		}

//  		header("Location: $link");
	}
?>

<html>
	<head>
		<title>Shorten your URL.</title>
	</head>
	<body><?php

?>
		<form action="./short/short.php" method="post">
			<input type="text" name="url_box" size="200" />
			<br />
			<input type="submit" name="shorten" Value="Shorten" />
		</form>
	</body>
</html>