<?
// 데이터베이스 설정파일
require_once 'common.php';
// simple html dom 라이브러리
require_once 'simple_html_dom.php';

//문자열로부터simple_html_dom오브젝트를 생성할 경우
//$html_data = str_get_html("문자열html");
// URL로부터imple_html_dom오브젝트를 생성할 경우
//$html_data = file_get_html("웹주소");

//토렌트 사이트의 카테고리명 정의
$category = array ( "torrent_tv","torrent_docu", "torrent_variety", "torrent_ani", "torrent_mid" );
//페이지수 정의
$pages = array ("1","2","3","4","5","6","7","8","9","10");
//$pages = array ("1");

$domain = "https://torrentkim10.net";

$sql = " insert into torrentData(title, img_url, url, download_link) values";
$row_data = "";
$start_time = date("Y-m-d H:i:s",time());
foreach ($category as $cate) {
    foreach ($pages as $page) {
        //URL로부터imple_html_dom오브젝트를 생성할 경우
        $domain_url = $domain . "/" . $cate . "/torrent" . $page . ".htm";

        $url_data = file_get_html($domain_url);

        //tr태그 단위로 추출
        foreach ($url_data->find('tr.bg0|tr.bg1') as $element) {

            $img_url =  "";
            $subject = ""; 
            $url = "";
            $magnet_link = "";

            //제목과 게시판URL취득
            foreach ($element->find('td.subject') as $element_subject) {
                foreach ($element_subject->find('a') as $element_subjecttag) {
                    $subject = $element_subjecttag->innertext;
                    $url = $domain . str_replace("..", "" , $element_subjecttag->href);
                }
            }

            $board_data = file_get_html($url);            
            foreach ($board_data->find('a') as $magnet) {
                // echo $magnet."\n";
                if ($magnet->target == "hiddenframe") {
                    if (!preg_match('/bbs\/download.php/i', $magnet->href)) {
                        continue;
                    } else {
                        $magnet_link = $domain . $magnet->href;
                        break;
                    }
                }
            }

            if (empty($magnet_link)) {
                continue;
            }

            //제목이 취득이 안된것은 디비에 저장 안함을 위한 조건
            if (empty($subject)) {
                continue;
            }

            $row_data .= "('" . $subject . " " . ' ' . "','". '1' . "','" . $url ."','" . $magnet_link . "'),";
        }
    }
}

$query = $sql . $row_data;
$query = substr ($query, 0, strlen($query)-1);
mysql_query($query, $cid) or die(mysql_error());

//디비에 중복된 데이터 삭제
$query = "delete from torrentData where id not in ( select id  from (select id  from torrentData group by title) as b);";
mysql_query($query, $cid) or die(mysql_error());

$end_time = date("Y-m-d H:i:s",time());
echo "start time :" . $start_time . "\n";
echo "endt  time :" . $end_time . "\n";
