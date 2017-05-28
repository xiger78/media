<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>미디어검색</title>
        <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" />
    </head>
<body>
<?php
    function file_download($url){
        exec('transmission-remote -a ' . $url, $result); 
    }

    function file_get_download($url, $dir) {
        if ( ! is_dir($dir) ){ die("디렉토리({$dir})가 존재하지 않습니다.。");}
        $dir = preg_replace("{/$}","",$dir);
        $p = pathinfo($url);
        $local_filename = '';
        $save_base_name = date('YmdHms');
        if ( $save_base_name ){ $local_filename = "{$dir}/{$save_base_name}.torrent"; }
        else{ $local_filename = "{$dir}/{$p['filename']}.torrent"; }
        //else{ $local_filename = "{$dir}/{$p['filename']}.{$p['extension']}"; }
        if ( is_file( $local_filename ) ){ print "이미 파일({$local_filename})이 존재합니다.<br>\n";}
        $tmp = file_get_contents($url);
        if (! $tmp){ die("URL({$url})로부터 다운로드 실패했습니다。");}
        $fp = fopen($local_filename, 'w');
        fwrite($fp, $tmp);
        fclose($fp);
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
            //file_download(rawurldecode($posturl));
            file_get_download(rawurldecode($posturl),"torrent");
        }
    }
?>
<?

$getip = array();
exec("curl ipv4.icanhazip.com", $getip, $return_var);
?>
<a href="http://koreanstudy.iptime.org:7777/media/"><B>토렌트검색화면</B></a><BR><BR><a href="http://koreanstudy.iptime.org:9091"><B>
다운로드현황보기</B></a>
</body>
</html>
