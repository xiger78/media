<?
$DB_SERVER = 'localhost';
$USERID = 'xxxxx';
$PASSWD = 'xxxxxr';
$DB='torrentdata';
$cid= mysql_connect($DB_SERVER,$USERID,$PASSWD) or die(mysql_error()) ;
mysql_select_db($DB,$cid) or die(mysql_error());

?>
