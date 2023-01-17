<?php
error_reporting(0);
header('Content-type: application/json;');
//========================================================= 
function convertPersianToEnglish($string) {
$persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
$english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
$output= str_replace($persian, $english, $string);
return $output;
}
//========================================================= 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://arzdigital.com/coins/");
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.130 Safari/537.36");
$get= curl_exec($ch);
curl_close($ch);

//$get=file_get_contents("https://arzdigital.com/coins/");
//=========================================================1 
preg_match_all("#data-faname='(.*?)' data-name='(.*?)' data-slug='(.*?)' data-symbol='(.*?)'><td#",$get,$name1);
$namefa=$name1[1];
$nameen=$name1[2];
$namad=$name1[4];
//========================================================= 
preg_match_all('#pulser-change="(.*?)">(.*?)</span>#',$get,$dollar1);
$dollar=$dollar1[2];
$rep = str_replace(["$"],[""],$dollar);            
//========================================================= 
preg_match_all('#<span class="(.*?)">(.*?)</span><span class="arz-toman arz-value-unit">#',$get,$toman1);
$toman=$toman1[2];
//========================================================= 
for($i=0;$i<=count($dollar)-1;$i++){

$da =['fa-name'=>$namefa[$i],'en-name'=>$nameen[$i],'grade'=>$namad[$i],'p-toman'=>convertPersianToEnglish($toman[$i]),'p-dolar'=>$rep[$i]];
$pptpr[]=$da;
}
//========================================================= 
echo json_encode(['ok' => true, 'channel' => '@SIDEPATH','writer' => '@meysam_s71',  'Results' =>$pptpr], 448);
//========================================================= 


