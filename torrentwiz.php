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
$category = array ( "torrent_movielatest","torrent_ent", "torrent_drama", "torrent_sisa", "torrent_movieko" );
//페이지수 정의
$pages = array ("p1","p2","p3","p4","p5","p6","p7","p8","p9","p10");

$sql = " insert into torrentData(title, img_url, url, download_link) values";
$row_data = "";
$start_time = date("Y-m-d H:i:s",time());
foreach ($category as $cate) {
    foreach ($pages as $page) {
        //URL로부터imple_html_dom오브젝트를 생성할 경우
        $url_data = file_get_html("https://torrentwiz3.com/". $cate . "/". $page);

        $i = 0;
        //tr태그 단위로 추출
        foreach ($url_data->find('tr') as $element) {

            $img_url =  "";
            $subject = ""; 
            $url = "";
            $magnet_link = "";

            if ($i==0) {
                $i++;
                continue;
            }

            //카테고리명취득
            $category = $element->find('span.text-muted', 0)->innertext;
            //영상이미지 정보취득
            foreach ($element->find('div.img-item') as $element_img) {
                foreach ($element_img->find('img') as $element_imgtag) {
                    $img_url = $element_imgtag->src;
                }
            }        

            //제목과 게시판URL취득
            foreach ($element->find('td.list-subject') as $element_subject) {
                foreach ($element_subject->find('a') as $element_subjecttag) {
                    $subject = substr($element_subjecttag->innertext, 0, strpos($element_subjecttag->innertext, '<span'));
                    $subject = str_replace("'", "", $subject);
                    $url = $element_subjecttag->href;
                }
            }

            //토렌트마그넷 주소생성
            $board_data = file_get_html($url);            
            foreach ($board_data->find('a') as $magnet) {
                if ($magnet->class == "btn btn-color btn-xs view_file_download") {
                    $magnet_link = $magnet->href;
                    break;
                }
            }

            //게시판에 등록된 동영상 사이즈 정보
            $size = $element->find('td.td_size2600', 0)->innertext;

            //제목이 취득이 안된것은 디비에 저장 안함을 위한 조건
            if (!empty($subject)) {
                $row_data .= "('" . $subject . "size : " . $size . "','". $img_url . "','" . $url ."','" . $magnet_link . "'),";
            }
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
