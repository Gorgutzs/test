<?php

//Controler für den Admin bereich


//Die Eingebunden Dateien
require_once __DIR__."/../config/Database.php";
require_once __DIR__."/../models/Events.php";
require_once __DIR__."/../models/Fehlermeldung.php";

class AdminController
{
//Die Properties
private Database $database;
private Fehlermeldung  $fm;
private Events $event;

public function __construct()
{

    $this->database = new Database();
    $this->event = new Events($this->database->getConnection());
    $this->fm = new Fehlermeldung($this->database->getConnection());
}


//Ruft die Main Admin Dashborad Seite auf
public function index()
{
if (!isset($_SESSION["user_id"])) {
        header("Location: /ProjektVeranstaltungen/login");
        exit;
    }
}


public function logout()
{
    session_destroy();
    header("Location: /ProjektVeranstaltungen");

}


//Ruft die Admin Error seite auf
public function error_site()
{

require_once __DIR__."/../views/admin/adminberich.php";

}


}