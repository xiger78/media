<?
include "common.php";

if(isset($_POST["cyear"]) && isset($_POST["cmonth"])){
    if(strlen($_POST["cmonth"])==1){
        $mm="0".$_POST["cmonth"];
    }else{
        $mm=$_POST["cmonth"];
    }

    $curdate=$_POST["cyear"].$mm;
}else{
    $curdate = date("Ymd");
    $curdate = substr($curdate, 0, -2);
}
	
$query="select
            id,             -- no 		    0
            title,          -- title      1
            img_url,        -- img_url    2
            download_link,  -- file     	3
            regdate         -- regdate		4
        from 
            torrentData
	      where
            title like '%". $_GET['keyword'] ."%' AND
            EXTRACT(YEAR_MONTH FROM regdate)='". $curdate  ."' 
            order by id desc ";
	
$row=mysql_query ( $query, $cid ) or die(mysql_error());

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
           <th>포스터</th>
           <th>제목</th>
        </tr>
           <?php
           while($rs=mysql_fetch_row($row)) {                        
           ?>
           <tr >
               <td align="center" width="20%">
                   <input type="checkbox" name="selects<?=$rs[0]?>" id="selects<?=$rs[0]?>" style="width:50px;height:80px">
               </td>
               <td align="center">
                   <img src="<?=$rs[2]?>" width="100px" height="150px">
               </td>               
               <td width="80%" style="word-break: break-all;">
                   <?=$rs[1]?>
                   <input type="hidden" name="url<?=$rs[0]?>" id="url<?=$rs[0]?>" value="<?=$rs[3]?>">
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

