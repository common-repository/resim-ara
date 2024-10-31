<?php
echo $_GET['kelime'];
$cevirilecek = $_GET['kelime'];
$search = array('Ç','ç','Ğ','ğ','ı','İ','Ö','ö','Ş','ş','Ü','ü',' ');
$replace = array('c','c','g','g','i','i','o','o','s','s','u','u','-'); 
$cevirilecek = str_replace($search,$replace,$cevirilecek);
$curl = curl_init('https://www.bing.com/images/search?q='.$cevirilecek.'&FORM=HDRSC2');
curl_setopt($curl, CURLOPT_FAILONERROR, true);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$result = curl_exec($curl);
$result = str_replace("\"/","\"https://www.bing.com/",$result);
$result = iconv('ISO-8859-9','UTF-8',$result);
echo "<meta charset=\"UTF-8\"/>";
echo $result;
?>