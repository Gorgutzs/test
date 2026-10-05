<?php

//Model für die Fehlermeldung des Users

class Fehlermeldung 
{

private $db;

public function __construct($db)
{

    $this->db = $db;

}

//Fehler neldung wird in die Datenbank gespeichert
public function createErrorMessage($text)
{

$sql = "INSERT INTO Fehlermeldung (Fehlermeldung) VALUES (:text)";

$stm = $this->db->prepare($sql);


$stm->bindValue(":text",$text, PDO::PARAM_STR);

$stm->execute();



}


}