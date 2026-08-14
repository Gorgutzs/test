<?php

require_once __DIR__ . "/../Models/event.php";
require_once __DIR__ . "/../config/Database.php";

class EventControler
{

private Database $database;
private Events $event;
private int $eventsPerPage =9;
private int $totalEvents;
private int $totalPages ;




public function __construct()
{
    $this->database = new Database();
    $this->event = new Events($this->database->getConnection());
    $this->totalEvents = $this->event->getEventCount();
    $this->totalPages = Ceil($this->totalEvents/$this->eventsPerPage);
}

public function showAll()
{

$result= $this->event->getAllEvents();

return $this->dateSort($result);

}


public function getEvents()
{

$page = isset($_GET["page"])
        ? (int) $_GET["page"]
        : 1;

    if ($page < 1) {
        $page = 1;
    }

    $offset = ($page - 1) * $this->eventsPerPage;

    $events = $this->event->getEvents(
        $this->eventsPerPage,
        $offset
    );



    return [
        "events" => $events,
        "page" => $page,
        "totalPages" => $this->totalPages
    ];

}








private function dateSort($unsort)
{
    

    for($i=0;$i<count($unsort);$i++)
        {
        
            $date = new DateTime($unsort[$i]["date"]);
            $unsort[$i]["date"] = $date->getTimestamp();
        }


    for($i=0;$i<count($unsort);$i++)
        {

            
                for($j=$i+1;$j<count($unsort);$j++)
                    {
                    if($unsort[$i]["date"]<$unsort[$j]["date"])
                        {
                        $tmp = $unsort[$i];
                        $unsort[$i] = $unsort[$j];
                        $unsort[$j] = $tmp;
                        }     
                    }
            
        }
        
        for($i=0;$i<count($unsort);$i++)      
        {
            $date = new DateTime();
            $date->setTimestamp($unsort[$i]["date"]);
            $unsort[$i]["date"]=$date->format("d.m.Y");

        }

    return $unsort;
    
}




}


