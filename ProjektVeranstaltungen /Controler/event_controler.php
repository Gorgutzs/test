<?php

require_once __DIR__ . "/../Models/event.php";
require_once __DIR__ . "/../config/Database.php";

class EventControler
{

private Database $database;
private Events $event;

public function __construct()
{
$this->database = new Database();
$this->event = new Events($this->database->getConnection());
}

public function showAll()
{

$result= $this->event->getAllEvents();

return $this->dateSort($result);



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
        if(count($unsort)>0)
            {
                for($j=1;$j<count($unsort);$j++)
                    {
                    if($unsort[$i]["date"]<$unsort[$j]["date"])
                        {
                        $tmp = $unsort[$i];
                        $unsort[$i] = $unsort[$j];
                        $unsort[$j] = $tmp;
                        }     
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


