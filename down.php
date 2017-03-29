<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" />
    </head>
<body>
<?php
    function file_download($url){
        exec('transmission-remote -a ' . $url, $result); 
    }
	
    $i = 1;
    
    //var_dump($_POST);
    $post=array_keys($_POST);
    for($i=0;$i<count($post);$i++)
    {
        if($_POST[$post[$i]]=="on")
        {
            $urlkey = explode("selects",$post[$i]);
            $posturl = rawurldecode($_POST["url".$urlkey[1]]);
            file_download(rawurldecode($posturl));
        }
    }
?>
<?

$getip = array();
exec("curl ipv4.icanhazip.com", $getip, $return_var);
?>
<a href="http://<?=$getip[0]?>:7777/media/"><B>토렌트검색화면</B></a><BR><BR><a href="http://<?=$getip[0]?>:9091"><B>다운로드현황보기</B></a>
</body>
</html>
