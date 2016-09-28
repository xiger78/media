<?php 
session_start(); 
include "./common.h";
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<title>Webhard</title>
<?
if($_GET['cur']== "admin" && $_GET['new']!="")
{

	$query = "insert into webhardadmin ";
		$query.= "(passwd";
		$query.= ") values (";
		$query.= "'".$_GET['new']."')";

	//echo $query."<BR>";

	if((substr($ip,0,7) == "192.168") == false){
		mysql_query($query, $cid) or die(mysql_error());
		echo "패스워드가 등록되었습니다.";
	}
}else{
	echo "패스워드가틀립니다.";
}
?>
</body>
</html>
<?php
 ?>
