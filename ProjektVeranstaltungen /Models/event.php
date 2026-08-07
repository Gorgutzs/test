<?php

class Events 
{


 
private $db;

public function __construct($db)
{

    $this->db = $db;

}


public function getAllEvents()
{
    
    //stm für stament
    $stmt= $this->db->prepare("Select * FROM event");
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


}

