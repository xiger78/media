<?
	include "common.php";

	$query="select
				id,             -- no 			0
				title, 		-- title 		1
				download_link,  -- file         	2
				regdate 	-- regdate		3
			from 
				torrentData
			order by id desc ";
	
	$row=mysql_query ( $query, $cid ) or die(mysql_error());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    </head>
<body>
<form name="test" id="test" method="post">
<?php 
    $yy=substr($curdate,0,4);
?>
<form action="./update.php" name="frm" id="frm" method="post" target="ifra">
		<input type="hidden" name="updateSql" id="updateSql" value="first">
		<table border="1" width="100%" cellspacing="0" cellpadding="1" bordercolor="#333333">
			<tr>
				<th>no</th>
				<th>title</th>
				<th>regdate</th>
			</tr>
			<?php
            $row_num = 1;
			while($rs=mysql_fetch_row($row)) {
			?>
			<tr >
				<td id="no">
					<?=$row_num?>
					<input type="hidden" name="no" id="no" value=<?=$rs[0]?>>
				</td>
				<td id="title"><?=$rs[1]?></td>
				<td id="regdate"><?=$rs[3]?></td>
			</tr>
			<?php
			// end roof
                $row_num++;
			}
			?>	
		</table>
		</form>
</body>
</html>

