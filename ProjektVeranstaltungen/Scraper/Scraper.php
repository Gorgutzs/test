<?php 

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once __DIR__."/../config/Database.php";
require_once __DIR__."/../models/Events.php";
require_once __DIR__."/../models/Source.php";
require_once __DIR__."/../models/Scrap_log.php";
require_once __DIR__."/Parser.php";
require_once __DIR__."/HttpClient.php";

class Scraper
{

private $db;
private $scrap_log;
private $sourceModel;
private $eventModel;
private $parser;
private $httpClient;



public function __construct()
{

$this->db = new Database();
$this->scrap_log = new Log($this->db->getConnection());
$this->sourceModel = new Source($this->db->getConnection());
$this->eventModel = new Events($this->db->getConnection());
$this->parser = new Parser();
$this->httpClient = new HttpClient();
}


public function test(){echo "hat gefuntzt";}


public function ScrapeOne($id)
{
    
 $source = $this->sourceModel->getUrlandRule($id);
 $counter=0;
    
            $events=[];
            $url = $source[0]["url"];
            $rule = json_decode($source[0]["scraper_rule"],true);

            $html=$this->httpClient->get($url);
            if($html["http-error"]!==null)
                {
                    
                    $this->scrap_log->createLog($this->sourceModel->getIDbyURL($url),"Error",$html["http-error"]);
                    return;
                }
            else if($html["curl-error"]!==null)
                {
                    $this->scrap_log->createLog($this->sourceModel->getIDbyURL($url),"Error",$html["curl-error"]);
                    return;
                }
                    
              

            $ausgabe=$this->parser->Parsen($rule,$html["html"],$url);

            if(is_string($ausgabe))
                {
                    $this->scrap_log->createLog($this->sourceModel->getIDbyURL($url),"Error",$ausgabe);
                    return;
                }

            if(empty($ausgabe["events"]))
                {
                    $this->scrap_log->createLog($this->sourceModel->getIDbyURL($url),"Error","Keine Events gefunden!");
                    return;
                }

            $nextUrl=$ausgabe["pagnation"];
            $counter+=$ausgabe["counter"];
            $events=array_merge($events,$ausgabe["events"]);




            $visitedUrls = [];

            while(!empty($nextUrl))
                {

                    $html=$this->httpClient->get($nextUrl);
    
                     if (in_array($nextUrl, $visitedUrls, true)) 
            {$this->scrap_log->createLog(
            $this->sourceModel->getIDbyURL($url),
            "Error",
            "Pagination-Schleife erkannt: " . $nextUrl );
            break;
            }

            $visitedUrls[] = $nextUrl;

            if($html["http-error"]!==null)
                {
                    
                    $this->scrap_log->createLog($this->sourceModel->getIDbyURL($url),"Error",$html["http-error"]);
                    break;
                }
            else if($html["curl-error"]!==null)
                {
                    $this->scrap_log->createLog($this->sourceModel->getIDbyURL($url),"Error",$html["curl-error"]);
                    break;
                }

            $ausgabe=$this->parser->Parsen($rule,$html["html"],$url);
            
                if(empty($ausgabe["events"]))
                {
                    $this->scrap_log->createLog($this->sourceModel->getIDbyURL($url),"Warrning","Keine Events gefunden! In der URL:".$nextUrl);
                    break;
                }

            $nextUrl=$ausgabe["pagnation"];
            $counter+=$ausgabe["counter"];
            $events=array_merge($events,$ausgabe["events"]);
                }
           
            $newEntrys = $this->eventModel->saveEvents($events,$this->sourceModel->getIDbyURL($url));

         
        
            //Meldung welche wie viele neu evets von dieser Source esgibt 

                $this->scrap_log->createLog($this->sourceModel->getIDbyURL($url),"Info","Es wurde: ".$newEntrys." eingefügt.");


            echo $counter;
        }
       













public function ScrapeAll()
{
    $sources = $this->sourceModel->getAllUrlsAndRules();
    $counter=0;
    foreach($sources as $source)
        {
        
            $events=[];
            $url = $source["url"];
            $rule = json_decode($source["scraper_rule"],true);

            $html=$this->httpClient->get($url);
            if($html["http-error"]!==null)
                {
                    
                    $this->scrap_log->createLog($this->sourceModel->getIDbyURL($url),"Error",$html["http-error"]);
                    continue;
                }
            else if($html["curl-error"]!==null)
                {
                    $this->scrap_log->createLog($this->sourceModel->getIDbyURL($url),"Error",$html["curl-error"]);
                    continue;
                }
                    
              //echo "<pre>";
              



            $ausgabe=$this->parser->Parsen($rule,$html["html"],$url);

            if(is_string($ausgabe))
                {
                    $this->scrap_log->createLog($this->sourceModel->getIDbyURL($url),"Error",$ausgabe);
                    continue;
                }

            if(empty($ausgabe["events"]))
                {
                    $this->scrap_log->createLog($this->sourceModel->getIDbyURL($url),"Error","Keine Events gefunden!");
                    continue;
                }

            $nextUrl=$ausgabe["pagnation"];
            $counter+=$ausgabe["counter"];
            $events=array_merge($events,$ausgabe["events"]);





$visitedUrls = [];

            while(!empty($nextUrl))
                {

                    $html=$this->httpClient->get($nextUrl);
    
                     if (in_array($nextUrl, $visitedUrls, true)) {$this->scrap_log->createLog(
            $this->sourceModel->getIDbyURL($url),
            "Error",
            "Pagination-Schleife erkannt: " . $nextUrl
        );break;}

    $visitedUrls[] = $nextUrl;

            if($html["http-error"]!==null)
                {
                    
                    $this->scrap_log->createLog($this->sourceModel->getIDbyURL($url),"Error",$html["http-error"]);
                    break;
                }
            else if($html["curl-error"]!==null)
                {
                    $this->scrap_log->createLog($this->sourceModel->getIDbyURL($url),"Error",$html["curl-error"]);
                    break;
                }

            $ausgabe=$this->parser->Parsen($rule,$html["html"],$url);
            
                if(empty($ausgabe["events"]))
                {
                    $this->scrap_log->createLog($this->sourceModel->getIDbyURL($url),"Warrning","Keine Events gefunden! In der URL:".$nextUrl);
                    break;
                }

            $nextUrl=$ausgabe["pagnation"];
            $counter+=$ausgabe["counter"];
            $events=array_merge($events,$ausgabe["events"]);
                }
           
            $newEntrys = $this->eventModel->saveEvents($events,$this->sourceModel->getIDbyURL($url));

         
        
            //Meldung welche wie viele neu evets von dieser Source esgibt 

                $this->scrap_log->createLog($this->sourceModel->getIDbyURL($url),"Info","Es wurde: ".$newEntrys." eingefügt.");


//*/
        }
        echo $counter;


}
 



}