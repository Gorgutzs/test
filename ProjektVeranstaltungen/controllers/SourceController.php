<?php

require_once __DIR__ ."/../config/Database.php";
require_once __DIR__ . "/../models/Source.php";

class SourceController

{

private $database;
private $source;
private int $sourcesPerPage =5;
private int $totalSources;
private int $totalPages ;



public function __construct()
{
    $this->database = new Database();
    $this->source = new Source($this->database->getConnection());
    //Wie Viele Quellen es insgesamt gibt
    $this->totalSources = $this->source->getSourcesCount();
    //Wie viel Seite erstellt werden müssen 
    $this->totalPages = Ceil($this->totalSources/$this->sourcesPerPage);
}


public function index()
{
//Für denn Fall das man was sucht
$search = $_GET["Search"] ?? "";

//Falls $search leer ist werden alle Events ausgegen. Falls nicht werden nur die die mit $search überein stimmen angezeigt
if(empty($search))
    {
        $sourceListe = $this->getSources();
    }
else
    {

    }

    //Ein Bindung der Adminqullen
require_once __DIR__ ."/../views/admin/quellen.php";


}



public function getSources()
{
//Sieht nach ob es page schon in der url da ist falls nicht wird stander mässig auf 1 gesetzt
$page = isset($_GET["page"])
        ? (int) $_GET["page"]
        : 1;

    if ($page < 1) {
        $page = 1;
    }
    //Wo die suche der Datenbank startet
    $offset = ($page - 1) * $this->sourcesPerPage;

    //Anfrage ans Event Modeel wird geschickt
        $sources = $this->source->getSources(
        $this->sourcesPerPage,
        $offset
            );
   


    return [
        "sources" => $sources,
        "page" => $page,
        "totalPages" => $this->totalPages
    ];

}



public function deletetSource()
{
    $data = json_decode(file_get_contents("php://input"),true);
    $id = $data["id"];
    $this->source->delete($id);
    echo json_encode(["message" => "Hat gefuntzt"]);
    exit;
}


public function source_aktivieren_deaktivieren()
{
    $data = json_decode(file_get_contents("php://input"),true);
    $id = $data["id"];
    $this->source->aktivieren_deaktivieren($id);
    echo json_encode(["message" => "Hat gefuntzt"]);
    exit;
}

public function addSource()
{

$URL = $_POST["URL"];
$Name = $_POST["Name"];
$Scraper_Regel = $_POST["Scraper-Regel"];
$Aktivieren = isset($_POST["Aktivieren"]);


$this->source->addSource($URL,$Name,$Scraper_Regel,$Aktivieren);

}


}

