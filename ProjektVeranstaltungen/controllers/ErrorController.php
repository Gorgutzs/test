<?php

//

//Die Eingebunden Dateien
require_once __DIR__ . "/../models/Fehlermeldung.php";
require_once __DIR__ . "/../config/Database.php";

class ErrorController
{

//Die Properties
private Fehlermeldung $fm;
private Database $database ;

public function __construct()
{
$this->database = new Database();
$this->fm = new Fehlermeldung($this->database->getConnection());

}


// Function die die ErrorMessage von user in die Datenbank überträgt
public function createErrorMessage()
{
  
 $data = json_decode(
    file_get_contents("php://input"),
    true);


 $this->fm->createErrorMessage($data["fehler"]);

 echo json_encode([
            "success" => true
        ]);



}


}