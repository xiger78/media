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
}
//$util = new util();
//$dev=$util->getSysInfo();
//print_r($dev['sda1']);

?>