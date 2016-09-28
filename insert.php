<?php
$obj;
$i=0;
function findDateByKeyword($word)
{
    Global $obj;
    $homepage = file_get_contents('http://www.torrentproject.com/?s='.urlencode ( $word ).'&out=json&orderby=latest');
	$obj = json_decode($homepage, true);
	//print_r($obj);
	if ($obj === NULL && $obj["total_found"]==0) {
    	return;
	}
}

// for android application    
if(strlen($_GET["keyword"])!=0 && !isset($_GET["windows"])){
    findDateByKeyword($_GET["keyword"]);
    for($j=0;$j<sizeof($obj);$j++)
    {
        echo "(SEED=".$obj[$j]['seeds'].",MB=".$obj[$j]['torrent_size'].")".$obj[$j]['title'];
        echo "\n";
        echo "http://www.torrentproject.com/torrent/".strtoupper($obj[$j]['torrent_hash']).".torrent";
        echo "\n";
    }
}else{
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
	    <head>
	        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	        <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" />
	<!-- 디비에 등록할부분 -->
	<script>
			function index()
			{
				location.href="index.php";
			}
	        function filedown()
	        {
	            document.frms.submit();
	        }
	</script>
	<!-- 디비에 등록할부분 -->
	    </head>
	<body>
	<table cellspacing=0 cellpadding=0 width="100%">
	    <tr>
	        <td width="50%">
	            <form name="frmword" id="frmword" method="post">
	                <input type="button" name="btnRun" id="btnRun" value="재검색" onclick="javascript:index();" style="width:100%;height:80px;font-size:30">
	            </form>
	        </td>
	        <td width="50%">
	            <form name="frm" id="frm" method="post">
	                <input type="button" name="btnDn" id="btnDn" value="다운" onClick="javascript:filedown();" style="width:100%;height:80px;font-size:30">
	            </form>
	        </td>
	    </tr>
	</table>
	    <form action="./down.php" name="frms" id="frms" method="post">
	        <input type="hidden" name="updateSql" id="updateSql" value="">
	        <table border="1" width="100%" cellspacing="0" cellpadding="1" bordercolor="#333333">
	            <tr>
	                <!--<th>순서</th>-->
	                <th>선택</th>
	                <th>제목</th>
	            </tr>
	            <?php
	// for android application    
	if(strlen($_GET["keyword"])!=0 && isset($_GET["windows"])){
	    findDateByKeyword($_GET["keyword"]);

	        for($i=0;$i<sizeof($obj);$i++)
	    	{
	    		//2015-04-04 add
	    		if($obj[$i]=="") continue;
	            ?>
	            <tr >
	                <td align="center" width="20%">
	                    <input type="checkbox" name="selects<?php echo $i;?>" id="selects<?php echo $i;?>" style="width:50px;height:80px">
	                </td>
	                <td width="80%" style="word-break: break-all;">
	                    <a href="<?php echo rawurldecode("http://www.torrentproject.com/torrent/".strtoupper($obj[$i]['torrent_hash']).".torrent");?>"><?php echo "(Seed=".$obj[$i]['seeds'].",MB=".$obj[$i]['torrent_size'].")";?><BR><?php echo str_replace('\'','',$obj[$i]['title']);?></a>
	                    <input type="hidden" name="url<?php echo $i;?>" id="url<?php echo $i;?>" value="<?php echo rawurlencode("http://www.torrentproject.com/torrent/".strtoupper($obj[$i]['torrent_hash']).".torrent");?>">
	                </td>
	            </tr>
	            <?php
	            // end roof
            }
            ?>    
	        </table>
	    </form>
	<table cellspacing=0 cellpadding=0 width="100%">
	    <tr>
	        <td width="50%">
	                <input type="button" name="btnRun2" id="btnRun2" value="재검색" onclick="javascript:index();" style="width:100%;height:80px;font-size:30">
	        </td>
	        <td width="50%">
	                <input type="button" name="btnDn2" id="btnDn2" value="다운" onClick="javascript:filedown();" style="width:100%;height:80px;font-size:30">
	        </td>
	    </tr>
	</table>
	<BR>※사용설명서)<BR>
	1.&nbsp;검색단어에 검색된 목록이 표시된다. <BR>
	2.&nbsp;다운로드할 항목만 체크후 다운버튼을 클릭.<BR>
	3.&nbsp;이제 서버에서 자동으로 다운로드를 자동실행하게됩니다.
	</body>
	</html>
	<?
	    if(sizeof($obj)>0)
	    {
	        //echo "<SCRIPT LANGUAGE='JavaScript'> location.href='./view.php' </SCRIPT>";
	    }else{
	        echo "<SCRIPT LANGUAGE='JavaScript'> alert('검색된 토렌트정보가 없습니다. 재검색을 해주세요.'); </SCRIPT>";
	        //echo "<SCRIPT LANGUAGE='JavaScript'> location.href='./index.php' </SCRIPT>";
	    }
	}

}

?>
</body>
</html>
