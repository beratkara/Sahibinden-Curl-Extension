<html>
<head>
<title>Berat Kara - Bot - www.r10.net/members/96158-furkank.html</title>
</head>

<body>
<?php

include('function.php');
set_time_limit(0);
ignore_user_abort(true);

function convert(&$value, $key){
    $value = iconv('UTF-8','ISO-8859-9//IGNORE', $value);
}

function array_to_csv_function($array, $filename = "export.csv", $delimiter=";") {
    $header=null;
    $createFile = fopen($filename,"w+");
    foreach ($array as $row) {
        if(!$header)
		{
            fputcsv($createFile, array_keys($row), $delimiter);
            fputcsv($createFile, $row, $delimiter);
            $header = true;
        }
        else
            fputcsv($createFile, $row, $delimiter);
    }
    fclose($createFile);
}

function VeriOku2($Url,$data = NULL,$proxy = NULL){
			$Curl = curl_init ();
			curl_setopt($Curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
			curl_setopt($Curl, CURLOPT_URL, $Url);
			curl_setopt($Curl, CURLOPT_REFERER, 'https://www.linkedin.com/in/beratkara');
			curl_setopt($Curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($Curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($Curl, CURLOPT_FOLLOWLOCATION, true);
			
			$request_headers = array(
			  'Connection: keep-alive',
			  'Upgrade-Insecure-Requests: 1',
			  'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36',
			  'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
			  'Accept-Encoding: compressed',
			  'Accept-Language: en-US,en;q=0.9',
			);
			
			curl_setopt($Curl, CURLOPT_HTTPHEADER, $request_headers);
			
			if(!empty($data))
				curl_setopt($Curl, CURLOPT_POSTFIELDS, $data);
			
			curl_setopt($Curl, CURLOPT_ENCODING,  'gzip,deflate');
			if(!empty($proxy))
				curl_setopt($Curl, CURLOPT_PROXY, $proxy);
			
			curl_setopt($Curl, CURLOPT_CONNECTTIMEOUT, 5);
			curl_setopt($Curl, CURLOPT_TIMEOUT, 5);
			curl_setopt($Curl, CURLOPT_POSTREDIR, 3);
	
			$VeriOkux = curl_exec ($Curl);
			curl_close($Curl);
			return str_replace(array("\n","\t","\r"), null, $VeriOkux);
}

function getInData($gourl,$proxy)
{
	$inpage = VeriOku2($gourl,NULL,$proxy);
	if(strlen($inpage) == 0 || strpos($inpage,"Hata Sayfası") !== false)
		return null;
	
	echo "Gidilen Sayfa : ".$gourl."<br>".PHP_EOL;
	
	$data = array();
	
	preg_match('@<span class="classifiedId" id="classifiedId">(.*?)</span>@si', $inpage, $ilanno);
	preg_match('@<li>            <strong>                İlan Tarihi</strong>&nbsp;            <span>                (.*?)</span>        </li>@si', $inpage, $ilantarihi);
	preg_match('@{"name":"m2_brut","value":"(.*?)"}@si', $inpage, $m2burut);
	preg_match('@{"name":"m2_net","value":"(.*?)"}@si', $inpage, $m2net);
	preg_match('@<li>.*?<strong>Oda Sayısı</strong>.*?<span class=".*?">                (.*?)</span>.*?</li>@si', $inpage, $odasayisi);
	preg_match('@<li>.*?<strong>Bina Yaşı</strong>.*?<span class=".*?">                (.*?)</span>.*?</li>@si', $inpage, $binayasi);
	preg_match('@<li>.*?<strong>Bulunduğu Kat</strong>.*?<span class=".*?">                (.*?)</span>.*?</li>@si', $inpage, $bulundugukat);
	preg_match('@<li>.*?<strong>Kat Sayısı</strong>.*?<span class=".*?">                (.*?)</span>.*?</li>@si', $inpage, $katsayisi);
	preg_match('@<li>.*?<strong>Isıtma</strong>.*?<span class=".*?">                (.*?)</span>.*?</li>@si', $inpage, $isitma);
	preg_match('@<li>.*?<strong>Banyo Sayısı</strong>.*?<span class=".*?">                (.*?)</span>.*?</li>@si', $inpage, $banyo);
	preg_match('@<li>.*?<strong>Balkon</strong>.*?<span class=".*?">                (.*?)</span>.*?</li>@si', $inpage, $balkon);
	preg_match('@<li>.*?<strong>Site İçerisinde</strong>.*?<span class=".*?">                (.*?)</span>.*?</li>@si', $inpage, $site);
	preg_match('@<li>.*?<strong>Site Adı</strong>.*?<span class=".*?">                (.*?)</span>.*?</li>@si', $inpage, $siteadi);
	preg_match('@<li>.*?<strong>Krediye Uygun</strong>.*?<span class=".*?">                (.*?)</span>.*?</li>@si', $inpage, $kredi);
	preg_match('@<li>.*?<strong>Kimden</strong>.*?<span class=".*?">                (.*?)</span>.*?</li>@si', $inpage, $kimden);
	preg_match('@<div id="gmap" data-lat="(.*?)" data-lon="(.*?)".*?data-lang="tr" data-corrupt="false"></div>@si', $inpage, $konum);
	preg_match('@<div id="classifiedDescription" class="uiBoxContainer">        (.*?)</div>@si', $inpage, $aciklama);
	preg_match('@<h2>.*?<a href=".*?">                        (.*?)</a>.*?<span>/</span>.*?<a href=".*?">                                (.*?)</a>.*?<span>/</span>.*?<a href=".*?">                                (.*?)</a>.*?</h2>@si', $inpage, $lokasyon);
	preg_match('@<div class="classifiedDetailTitle">.*?<h1>(.*?)</h1>.*?</div>@si', $inpage, $title);
	preg_match('@<div class="classifiedInfo.*?">.*?<h3>                 (.*?)<input id="priceHistoryFlag" type="hidden" value="">.*?</div>@si', $inpage, $fiyat);

	$data['baslik'] = (!empty($title[1]) ? $title[1] : "");
	$data['fiyat'] = (!empty($fiyat[1]) ? $fiyat[1] : "");
	$data['no'] = (!empty($ilanno[1]) ? $ilanno[1] : "");
	$data['tarih'] = (!empty($ilantarihi[1]) ? $ilantarihi[1] : "");
	$data['m2net'] = (!empty($m2net[1]) ? $m2net[1] : "");
	$data['m2burut'] = (!empty($m2burut[1]) ? $m2burut[1] : "");
	$data['odasayisi'] = (!empty($odasayisi[1]) ? $odasayisi[1] : "");
	$data['binayasi'] = (!empty($binayasi[1]) ? $binayasi[1] : "");
	$data['bulundugukat'] = (!empty($bulundugukat[1]) ? $bulundugukat[1] : "");
	$data['katsayisi'] = (!empty($katsayisi[1]) ? $katsayisi[1] : "");
	$data['isitma'] = (!empty($isitma[1]) ? $isitma[1] : "");
	$data['banyo'] = (!empty($banyo[1]) ? $banyo[1] : "");
	$data['balkon'] = (!empty($balkon[1]) ? $balkon[1] : "");
	$data['site'] = (!empty($site[1]) ? $site[1] : "");
	$data['siteadi'] = (!empty($siteadi[1]) ? $siteadi[1] : "");
	$data['kredi'] = (!empty($kredi[1]) ? $kredi[1] : "");
	$data['kimden'] = (!empty($kimden[1]) ? $kimden[1] : "");
	$data['konum'] = (!empty($konum[1]) ? $konum[1].",".$konum[2] : "");
	$data['aciklama'] = (!empty($aciklama[1]) ? $aciklama[1] : "");
	$data['il'] = (!empty($lokasyon[1]) ? $lokasyon[1] : "");
	$data['ilce'] = (!empty($lokasyon[2]) ? $lokasyon[2] : "");
	$data['mahalle'] = (!empty($lokasyon[3]) ? $lokasyon[3] : "");

	return $data;
}

flush();
ob_get_contents();

$ipaddress = array();
$alldata = array();
$getdata =file_get_contents('proxy_http_ip.txt');
$getdata = explode(PHP_EOL, $getdata);
$ipaddress = $getdata;
shuffle($ipaddress);

$proxycountselect = 0;
$proxyallchecker = 0;
$page = 0;
$site = "https://www.sahibinden.com";
$proxy = $ipaddress[$proxycountselect];
$gidilcekurl = $site."/satilik-daire/izmir-buca?pagingSize=50&sorting=date_desc";

yenisayfa:

if($page > 0)
	$gidilcekurl .= "&pagingOffset=".(50*$page);

$Veri = VeriOku2($gidilcekurl,NULL,$proxy);
echo "Gidilen Sayfa : ".$gidilcekurl."<br>".PHP_EOL;

if(strlen($Veri) == 0)
	die("Proxyden veri gelmedi ! -> ".$proxy);

if(strpos($Veri,"Hata Sayfası") !== false)
	die("Yakalandık");

preg_match_all('@<tr.*?data-id=".*?".*?class="searchResultsItem.*?">(.*?)</tr>@si', $Veri, $data);

echo "Toplam Bulunan İlan Sayısı : ".count($data[1])."<br>".PHP_EOL;
for($i = 0; $i < count($data[1]); $i++)
{
	flush();
	ob_get_contents();
	preg_match('@<a class=".*?classifiedTitle".*?href="(.*?)">(.*?)</a>@si', $data[1][$i], $url);
	$title = $url[2];
	
	tekrar:
	
	if($proxyallchecker >= 5)//5 defa tüm proxyleri dolanır hepsi yakalndıysa işlemi durdurur
		break;
	
	$proxycountselect++;
	if($proxycountselect >= count($ipaddress)){
		$proxycountselect = 0;
		$proxyallchecker++;
	}
	
	$proxy = $ipaddress[$proxycountselect];
	$indata = getInData($site.$url[1],$proxy);
	if($indata == null)
		goto tekrar;
	else
	{
		array_walk($indata, 'convert');
		array_push($alldata,$indata);
		echo "Veriler Eklendi !<br>".PHP_EOL;
	}
	
	if($i == count($data[1]))
		$page++;
}

if($page > 0)
	goto yenisayfa;

array_to_csv_function($alldata, "export.csv");



?>

</body>
</html>