<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



$ordner = __DIR__ . "/quellen";


$daten = [];
$dateien = glob($ordner."/*.json");

//Daten aus den Ordner hollen
foreach ($dateien as $datei)
    { 
        $json = file_get_contents($datei);
        $inhalt = json_decode($json,true);
        $daten[]= $inhalt;
        var_dump($json);
    }

// Jede webiseite scrapenn
foreach( $daten as $data){


$ch = curl_init();
$zähler=0;
$url = $data["URL"] ?? " ";

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);

for($i=0;$i<3;$i++){
$html = curl_exec($ch);


if ($html === false) {
   
    $error = curl_error($ch);
    echo $error;
    $weiter =true;
    sleep(2);
    continue;
}

$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if ($httpCode >= 400) {

    // HTTP-Fehler speichern
 echo $httpCode;
 $weiter =true;
 sleep(2);
 continue;
}
$weiter = false;
break;

}
if($weiter){continue;}


while($url != null){

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);

$html = curl_exec($ch);



$dom = new DOMDocument();

libxml_use_internal_errors(true);
$dom->loadHTML($html);
libxml_clear_errors();

//$data=json_decode(file_get_contents("qulle.json"),true);

$eventsPath = $data["eventcard"];
$titlePath = $data["title"];
$timePath = $data["time"];
$datePath = $data["date"];
$ortPath = $data["place"]??null;
$linkPath = $data["link"];
//$nextPath = $data["pagnation"];




$xpath = new DOMXpath($dom);

$events = $xpath->query($eventsPath);

echo "Gefundene Events: " . $events->length . "<br><br>";
 echo $zähler;

foreach($events as $event)
    {
        //Tittle
        $titleNod = $xpath->query($titlePath,$event)->item(0);
        $titleNod = trim($titleNod->textContent);
        echo "Title: ".$titleNod."<br>";
        

        //Datum
        $dateNod = $xpath->query($datePath,$event)->item(0);
        preg_match_all('/\d{1,2}\.?[A-Za-zÄÖÜäöüß0-9]+\.?\d{2,4}/',$dateNod->textContent,$date);

        // '/\d{1,2}\.?[A-Za-zÄÖÜäöüß0-9]+\.?\d{2,4}/
        echo "Anfangs Datum: ".$date[0][0]."<br>";
        if(count($date[0])>1)
            {
                echo "End Datum: ".$date[0][1]."<br>";
            }
if($timePath === null){
            //Zeit
            $timeNod = $xpath->query($timePath,$event)->item(0);
            preg_match_all('/\b([01]?\d|2[0-3]):[0-5]\d\b/',$timeNod->textContent,$time);
            if($time[0]!=null)
                {
                    echo "Anfangs Zeit: ".$time[0][0]."<br>";
                    if(count($time[0])>1)
                        {
                            echo "End Zeit: ".$time[0][1]."<br>";
                        }
                }
            }

            //Ort
      //  $ortNode = $xpath->query($ortPath,$event)->item(0);
       // if($ortNode!=null)
            {
       //        $ort = trim($ortNode->textContent);
       //        $ort = preg_replace('/^[^A-Za-zÄÖÜäöüß]*/u', '', $ort);

       //       echo "Ort: ".$ort."<br>"; 
            }
            

        //Link
        $linkNode = $xpath->query($linkPath,$event)->item(0);
        if($linkNode!=null)
            {
                $link = $linkNode->getAttribute('href');
                $link = makeAbsoluteURL($link,$url);
                echo '<a href="'.$link.'"> <button> Link drücken </button></a>';

            }

    echo"<br><br>";
    }


   /* //pagnation
    $nextNode = $xpath->query($nextPath)->item(0);

    if($nextNode !=null)
        {
     $nextLink = $nextNode->getAttribute('href');

    $nextUrl = makeAbsoluteUrl($nextLink, $url);

    echo "Nächste Seite: " . $nextUrl;
    $zähler++;
   
    sleep(3);
    $url=$nextUrl;    
    
    
}   
    else
    {
        $url=null;     
    }

*/
}

}
echo "ende";
curl_close($ch);













function makeAbsoluteUrl($link, $baseUrl)
{
    if (empty($link)) {
        return null;
    }

    // Bereits vollständige URL
    if (preg_match('/^https?:\/\//i', $link)) {
        return $link;
    }

    $base = parse_url($baseUrl);

    $scheme = $base['scheme'];
    $host = $base['host'];

    // URL beginnt mit /
    if (substr($link, 0, 1) === '/') {
        return $scheme . '://' . $host . $link;
    }

    // Relativer Link
    $basePath = $base['path'] ?? '/';

    $directory = rtrim(dirname($basePath), '/');

    return $scheme . '://' . $host . $directory . '/' . $link;
}