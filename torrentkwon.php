<?
require_once 'common.php';
require_once 'simple_html_dom.php';

// 文字列からsimple_html_domオブジェクトを生成する場合
//$html_data = str_get_html($html);

// URLからsimple_html_domオブジェクトを生成する場合
$url_data = file_get_html("https://torrentna.xyz/bbs/board.php?bo_table=movie_us");

// divタグのid=hogeだけを抽出
$get_tr_tag = $url_data->find('td');
if (!is_null($get_tr_tag)) {
    $sql = " insert into torrentData(title, url, download_link) values";
    $row = "";
    foreach ($get_tr_tag as $element) {

        // タグの中身を全て?更
        if ($element->class == "td_subject") {
            $tr = $element->outertext;
            //echo $tr."\n";
            $tmp_row = '<html><body>' . $tr . '</body></html>';
            $row .= getChar($tmp_row, "a");
            
        }
    }
    $query = $sql . $row;
    $query = substr ($query, 0, strlen($query)-1);
    mysql_query($query, $cid) or die(mysql_error());
    // distinct data delete
    $query = "delete from torrentData where id not in ( select id  from (select id  from torrentData group by title) as b);";
    mysql_query($query, $cid) or die(mysql_error());
}

function getChar($html, $target)
{
    require_once 'simple_html_dom.php';
    $tr_row = str_get_html($html);
    $tag = $tr_row->find($target); 
    $datas = "";
    if (!is_null($tag)) {
        foreach ( $tag as $element) {
            if ($element->class != "bo_cate_link") {
                $tag_data = $element->outertext;
                $torrent_url = str_replace("&amp;amp;", "&", $element->href);
                $torrent_url = str_replace("&amp;", "&", $torrent_url);
                $torrent_title = $element->innertext;
                $torrent_id = preg_replace('/.*wr_id=/i', '', $torrent_url);
                if (preg_match('/&/i', $torrent_id)) {
                    $torrent_id = preg_replace('/&.*/i', '', $torrent_id);
                }
                //download=url;
                //https://torrentna.xyz/bbs/download.php?bo_table=movie_us&wr_id=2722&no=1
                $download_link="https://torrentna.xyz/bbs/download.php?bo_table=movie_us&wr_id=" . $torrent_id;
                //echo $tag_data . "\n";
                $datas .= "('" . $torrent_title . "','" . $torrent_url ."','" . $download_link . "'),";
            }
        }
    }
    return $datas;
}
