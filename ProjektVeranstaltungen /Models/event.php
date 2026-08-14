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

public function getEvents($limit,$offset)
{

    $sql = "SELECT * FROM event ORDER BY date DESC LIMIT :limit OFFSET :offset";

    $stmt = $this->db->prepare($sql);

    $stmt->bindValue(":limit",$limit,PDO::PARAM_INT);
    $stmt->bindValue(":offset",$offset, PDO::PARAM_INT);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

public function getEventCount()
{

    $sql = "SELECT COUNT(*) FROM event";

    $stmt = $this->db->prepare($sql);
    $stmt->execute();

    return $stmt->fetchColumn();

}


}

