<?php

require_once __DIR__."/../helpers/TimeHelpers.php";
require_once __DIR__."/../helpers/URLhelper.php";


class Parser
{



public function Parsen($json,$html,$url)
{
    

    $daten = $json;

    $eventsPath = $daten["eventcard"] ?? null;
    $titlePath = $daten["title"] ?? null;
    $timePath = $daten["time"] ?? null;
    $datePath = $daten["date"] ?? null;
    $ortPath = $daten["place"] ?? null;
    $linkPath = $daten["link"] ?? null;
    if(isset($daten["pagnation"]))
        {
            $nextPath = $daten["pagnation"];
        }
        
        if($eventsPath===null)
            {
                $fehler= "Fehler es fehlt: Eventcard";
                 return $fehler;
            }

        if($titlePath===null)
            {
                $fehler= "Fehler es fehlt: der Title";
                return $fehler;
            }

        if($linkPath===null)
            {
                $fehler= "Fehler es fehlt: der Link";
                return $fehler;
            }


    $zähler =0;
    $ausgabe=[
        "counter"=>0,
        "pagnation"=>null,
        "events"=>[]
        ];

   libxml_use_internal_errors(true);

$dom = new DOMDocument();
$dom->loadHTML($html);

libxml_clear_errors();
libxml_use_internal_errors(false);

    $xpath = new DOMXpath($dom);

    $events = $xpath->query($eventsPath);

 
    foreach($events as $event)
        {
            $temp=[
            "title"=>null,
            "start-time"=>null,
            "end-time"=>null,
            "start-date"=>null,
            "end-date"=>null,
            "place"=>null,
            "link"=>null
            ];


            $titleNode = $xpath->query($titlePath,$event);
            if($titleNode==false)
                {
                    $fehler = "Fehler: Title falscher XPath";
                    return $fehler;
                }
            else{
                    $titleNode= $this->union($titleNode);
               
            $temp["title"] = $titleNode;
                 }


        //Datum

        $dateNode = $xpath->query($datePath,$event);
        
        if($dateNode==false){
                    $fehler = "Fehler: Date falscher XPath";
                    return $fehler;
                    }
        else{$dateNode= $dateNode->item(0);
            if($dateNode!=null){
     
        preg_match_all('/\d{1,2}\.\s*(?:[A-Za-zÄÖÜäöüß]+|\d{2})\.?\s*\d{2,4}/u',$dateNode->textContent,$date);
        
        if(!empty($date[0])){
        $temp["start-date"]=HelperFunctionTime::dateNormalisieren($date[0][0]);
        if(count($date[0])>1)
            {
                $temp["end-date"]=HelperFunctionTime::dateNormalisieren($date[0][1]);
            }
        }
        }
        }

        //Zeit
        if($timePath!=null){
        $timeNode = $xpath->query($timePath,$event);
        if($timeNode==false)
            {
                    $fehler = "Fehler: Zeit falscher XPath";
                    return $fehler;
            }
            else
        {$timeNode = $timeNode->item(0);
            if($timeNode!=null){
        
        preg_match_all('/\b([01]?\d|2[0-3]):[0-5]\d\b/',$timeNode->textContent,$time);
        
        if(!empty($time[0]))
            {
                $temp["start-time"]=$time[0][0];
                if(count($time[0])>1)
                    {
                            $temp["end-time"]=$time[0][1];
                     }
            }
            }
            }
            }       
        //Ort
            if($ortPath!=null){
        $ortNode = $xpath->query($ortPath,$event);
        if($ortNode==false)
            {
                $fehler = "Fehler: Ort falscher XPath";
                    return $fehler;
            }
        else
            {
            $ortNode = $ortNode->item(0);        
            if($ortNode!=null){
               
               $ort = trim($ortNode->textContent);
               $ort = preg_replace('/^[^A-Za-zÄÖÜäöüß]*/u', '', $ort);

                $temp["place"]=$ort; 
            }
            }
            }
        //Link
        $linkNode = $xpath->query($linkPath,$event);
        if($linkNode==false)
            {
                $fehler = "Fehler: Link falscher XPath"; 
                return $fehler;}

            else{
                $linkNode = $linkNode->item(0);
         
                $link = $linkNode->getAttribute('href');
                $link = URLHelper::makeAbsoluteUrl($link,$url);
                $temp["link"] =$link;

            }
            $zähler++;
            $ausgabe["events"][]=$temp;
        }

        if(isset($nextPath))
            {
                $nextNode = $xpath->query($nextPath);
                if($nextNode !=false && $nextNode->length > 0)
                { $nextNode = $nextNode->item(0);

                if($nextNode->hasAttribute("href"))
                {
                
                
                if($nextNode !=null){
                
                $nextLink = $nextNode->getAttribute('href');

                   echo "<pre>";
                echo $nextLink;
                echo $url;
                echo "</pre>";
                $nextUrl = URLHelper::makeAbsoluteUrl($nextLink, $url);
                $ausgabe["pagnation"] = $nextUrl;
                echo "<pre>";
                echo $nextUrl;
                echo "</pre>";
            }
            }
            }}
            $ausgabe["counter"]=$zähler;




    return $ausgabe;
}


private function union($list)
{

$inhalt="";

foreach($list as $node)
    {
          $inhalt .= trim($node->textContent) . ' ';

    }
    return $inhalt;

}


}