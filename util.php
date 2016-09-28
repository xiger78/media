<?php
class util
{
    function getSysInfo()
    {
        exec("df -h > ./tmp/sysinfo");
        $fp=fopen("./tmp/sysinfo","r");
        $i=0;
        //파일 읽어와서 끝이 아닐때까지 반복
        $result = array();
        while (!feof ($fp)) 
        { 
           //파일에서 한줄한줄 읽어오기
           $buffer = fgets($fp); 
           if($buffer=="") break;
           //첫번째행은 헤더라 출력해서 스킵
           if($i!=0){
                //복수의 공백을 하나로 치환
                $tmp = preg_replace('/\s+/', ' ', $buffer);
                //print_r($tmp);
                //echo"======\n";
                //"/dev/"을 삭제
                //print_r($tmp);
                //공백으로 분할하여 배열로 생성
                $tmparr = split(" ",$tmp);
                //print_r($tmparr);
                if(strlen($tmparr[0])>7){
                    if(substr($tmparr[0],0,7)=="/dev/sd"){
                        $tmparr[0]=substr($tmparr[0],5,strlen($tmparr[0]));
                    }
                    //echo "substr=".substr($tmparr[0],5,strlen($tmparr[0]));
                }
                $result[$tmparr[0]] = array("Size"=>$tmparr[1],"Used"=>$tmparr[2],"Avail"=>$tmparr[3],"User"=>$tmparr[4],"Mounted"=>$tmparr[5]);
           }
           $i++;
        } 
        exec("sudo rm -f ./tmp/sysinfo");
        return $result;
    }
    function getTorrentRg($keyword)
    {
		require_once('simple_html_dom.php');

		//failed to open stream http request failed http/1.1 403 forbidden 
		//file_get_contents에서 에러가 나서 추가한 세줄
		ini_set("user_agent","Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)");
		ini_set("max_execution_time", 0);
		ini_set("memory_limit", "10000M");

		//게시판 리스트 설정
		$boardList;
		$i=0;
		$categoryStr = "torrent_movie";
		$cateKey = "tgg3";
		$boardIdKey = "gt3ty";
		//토렌트다운로드 URL생성
		$linkUrl = "http://www.torrentrg.net/bbs/hh4dd333hq.php?";
		//토렌트다운로드를 위한 키정보
		$keyStr = "&opwj=adq2dj&poiu=hh4dd333hq&akpq=amnwi";
		//wr_id를 추출하기위해 문자열길이 계산
		$delLinkSize = strlen("../bbs/board.php?bo_table=torrent_movie&wr_id=");
		$maxPage = 5;
		//$keyWord="";
		for($cnt=1;$cnt<=$maxPage;$cnt++)
		{
			if(strlen($keyWord)==0){
				$html = file_get_contents('http://www.torrentrg.net/bbs/board.php?bo_table=torrent_movie&page=' . $cnt);
			}else{
				$html = file_get_contents('http://www.torrentrg.net/bbs/board.php?bo_table=torrent_movie&sfl=wr_subject%7C%7Cwr_content&stx=' . $keyWord);
				$cnt = $maxPage;
			}

			//웹사이트 텍스트파일로 저장
			$fp=fopen("./test.txt","w");
			fwrite($fp, $html);
			fclose($fp);

			//게시판의 리스트 추출
			exec("grep -A 1703 mw_basic_list_num test.txt > grep.txt");

			//url하고 제목 추출
			exec("grep -A 2 'a href=\"../bbs' grep.txt > list.txt");

			$html = file_get_html('list.txt');
			foreach($html->find('a[title],a[href]') as $list) {
			    $category=$list->plaintext;
			    //카테고리 저장
			    if(substr($category,0,1)=="["){
			    	$boardList[$i]['cate'] = $category;
			    	continue;
			    }
			    //불필요한 url스킵
			    if(substr($category,0,1)=="+"){
			    	continue;
			    }
			    $title=$list->plaintext;
			    $links=$list->href;
			    //echo "title=".$title."\n";
			    //echo "link=".$links."\n";
			    $boardList[$i]['title']=$title;
			    //토렌트 파일 링크 생성
			    $tmp=substr($links,$delLinkSize,strlen($links));
			    $wr_id=substr($tmp,0,strpos($tmp,'&'));
			    $torrentLink = $linkUrl . $cateKey . "=" . $categoryStr . "&" . $boardIdKey . "=" . $wr_id . $keyStr;
			    $boardList[$i]['links']=$torrentLink;
			    $i++;
			}
			exec("rm -f ./test.txt");
			exec("rm -f ./grep.txt");
			exec("rm -f ./list.txt");
		}
		print_r($boardList);

		$html->clear();
		unset($html);
    }
}
//$util = new util();
//$dev=$util->getSysInfo();
//print_r($dev['sda1']);

?>