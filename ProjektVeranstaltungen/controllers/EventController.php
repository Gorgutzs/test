<?php

//Der EventController. Hier ist die EvenController classe die für alles was mit Even zur ausgabe zutun hat zuständig ist

//Die Eingebunden Dateien
require_once __DIR__ . "/../models/Events.php";
require_once __DIR__ . "/../config/Database.php";

class EventController
{

//Die Properties
private Database $database;
private Events $event;
// Wie viel Events pro Seite ausgegen werden sollen
private int $eventsPerPage =15;
private int $totalEvents;
private int $totalPages ;




public function __construct()
{
    $this->database = new Database();
    //Das Model wird mit der Datenbank verbunden
    $this->event = new Events($this->database->getConnection());
    //Wie Viele Events es insgesamt gibt
    $this->totalEvents = $this->event->getEventCount();
    //Wie viel Seite erstellt werden müssen 
    $this->totalPages = Ceil($this->totalEvents/$this->eventsPerPage);
}


//Funktion zu erstellung der Userhaupseite
public function index()
{
//Für denn Fall das man was sucht
$search = $_GET["Search"] ?? "";

//Falls $search leer ist werden alle Events ausgegen. Falls nicht werden nur die die mit $search überein stimmen angezeigt
if(empty($search))
    {
        $events = $this->getEvents();
    }
else
    {
        $events = $this->getSearchEvents($search);
    }

    //Ein Bindung der Userhaupseite
require_once __DIR__. "/../views/user/liste.php";

}






//Aufruf der Admin_Events Seite

public function AdminEvents()
{

$events = $this->getEvents();


require_once __DIR__. "/../views/admin/veranstalungen.php";


}

public function DeletetEvent()
{
    $data = json_decode(file_get_contents("php://input"),true);
    $id = $data["id"];
    $this->event->delete($id);
    echo json_encode(["message" => "Hat gefuntzt"]);
    exit;
}






// Function die Alle Events wieder ausgibt 
public function getEvents()
{
//Sieht nach ob es page schon in der url da ist falls nicht wird stander mässig auf 1 gesetzt
$page = isset($_GET["page"])
        ? (int) $_GET["page"]
        : 1;

    if ($page < 1) {
        $page = 1;
    }
    //Wo die suche der Datenbank startet
    $offset = ($page - 1) * $this->eventsPerPage;

    //Anfrage ans Event Modeel wird geschickt
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


//Function die nur die Gesuchten Events wieder gibt
public function getSearchEvents($search)
{

//Was geseacht werden soll. Das % Symbol bedeuet das belibig viele Zeichen vor und nach $search stehen dürfen
$search = "%".$search."%";

//Wo die suche der Datenbank startet
$page = isset($_GET["page"])
        ? (int) $_GET["page"]
        : 1;

    if ($page < 1) {
        $page = 1;
    }

    //Wo die suche der Datenbank startet
    $offset = ($page - 1 ) * $this->eventsPerPage;
    
    //Wie viele seite gebraucht werden
    $totalPages = ceil($this->event->getSearchCount($search)/$this->eventsPerPage);

    //Anfrage ans Event Modeel wird geschickt
    $events = $this->event->getSearchEvents(
        $this->eventsPerPage,
        $offset,
        $search
    );
    

    return [
        "events"=>$events,
        "page"=>$page,
        "totalPages" => $totalPages,
        "search" => trim($search,"%")
    ];

}

}



