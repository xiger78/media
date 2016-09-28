<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" />
        <script>
        function chkWord()
        {
            if(document.frm.txtKeyWord.value=="")
            {
                alert("검색단어를 입력해주세요");
                return false;
            }
        }
        function insert(param)
        {
            if(document.frm.txtKeyWord.value=="")
            {
            	alert("검색어를 입력해주세요.");
            	document.frm.txtKeyWord.focus();
            	return false;
            }
            
            //location.href="insert.php?windows="+param+"&keyword=" + document.frm.txtKeyWord.value;
            document.frm.action="insert.php?windows="+param+"&keyword=" + document.frm.txtKeyWord.value;
            document.frm.submit();
        }
        </script>
    </head>
<body>
		<form name="frm" id="frm" method="post" action="">
		<table width="100%">
    	<tr>
			<td><p style="font-size=20px">토렌트검색어</p></td>
		</tr>
		<tr>
		<td align=center>
		    <table width="100%" align=center>
		        <tr>
		            <td>
		            <!--onKeyPress="if(event.keyCode == 13) alert('검색버튼을 눌러주세요.');return false;"-->
		                    <input type="text" name="txtKeyWord" id="txtKeyWord" value="" size="25px" style="width:100%;height:50px">
		            </td>
		            <td>
		                    <input type="submit" name="btnRun" id="btnRun" value="검색" onClick="javascript:insert(1)" style="width:80px;height:50px">
		                
		            </td>
		        </tr>
		    </table>
		</td>
	</tr>
</table>
						</form>
<B><?php echo $resultStr;?></B>
<BR>※사용설명서)<BR>
1.&nbsp;다운로드할 검색어를 입력합니다.<BR>
2.&nbsp;검색 버튼을 클릭합니다.<BR>
<?php
include "util.php";
$util = new util();
$sysinfo=$util->getSysInfo();
?>
<?php echo "==서버정보==";?>
<table>
<tr><td><?php echo "전체용량";?></td><td><?php echo $sysinfo['sda1']['Size'];?></td></tr>
<tr><td><?php echo "사용량";?></td><td><?php echo $sysinfo['sda1']['Used'];?></td></tr>
<tr><td><?php echo "남은용량"?></td><td><?php echo $sysinfo['sda1']['Avail'];?></td></tr>
<tr><td><?php echo "사용율";?></td><td><?php echo $sysinfo['sda1']['User'];?></td></tr>
</table>
</body>
</html>