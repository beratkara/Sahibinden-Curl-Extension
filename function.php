<?php

//header('Content-Type: charset=utf-8');

set_time_limit(0);
error_reporting(E_ALL);

/* Bot Function */
function VeriOku($Url,$Tarayici = false){ 

    if(!$Tarayici)
        $Tarayici = 'Mozilla/5.0 (iPhone; U; CPU like Mac OS X; en) AppleWebKit/420+ (KHTML, like Gecko) Version/3.0 Mobile/1A543a Safari/419.3';
 
    $Curl = curl_init ();
	curl_setopt($Curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
    curl_setopt($Curl, CURLOPT_URL, $Url);
    curl_setopt($Curl, CURLOPT_USERAGENT, $Tarayici);
    //curl_setopt($Curl, CURLOPT_REFERER, 'http://www.google.com');
    curl_setopt($Curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($Curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($Curl, CURLOPT_FOLLOWLOCATION, 0);
	$cerez=str_replace('\\','/',dirname(__FILE__)).'/cerez.txt';
	curl_setopt($Curl,CURLOPT_COOKIEFILE,$cerez);
	curl_setopt($Curl,CURLOPT_COOKIEJAR,$cerez);
	curl_setopt($Curl, CURLOPT_ENCODING,  'gzip,deflate');
	curl_setopt($Curl, CURLOPT_POSTREDIR, 3);
    $VeriOku = curl_exec ($Curl);
    curl_close($Curl);
	return str_replace(array("\n","\t","\r"), null, $VeriOku);
     
}

function file_download($link,$dosya_adi){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$link);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	$dosya=curl_exec($ch);
	curl_close($ch);

	$dosyayolu = dirname( __FILE__ )."/";

	$fp = fopen($dosyayolu."/images/".$dosya_adi,'w');
	fwrite($fp, $dosya);
	fclose($fp);
}

?>