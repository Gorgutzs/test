<?php 

//Die Index datei. Hier starte das Program und wird von allen seiten auf gerufen alls erste.

// Zum ansehen von Fehler
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

//Einbindung der Route datei
require_once __DIR__."/../routes/Routes.php";

//Die Session wird gestarte wichtig fürs Anmleden des Admins 
//Werde ich wohl aber noch ändern
session_start();

//Erstellung des Routers und ausführung seiner Funktion
$route = new Routes();
$route->run();

