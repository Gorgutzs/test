<?php


class Log
{

private $db;

public function __construct($db)
{

    $this->db = $db;

}


public function createLog($id,$status,$message)
{

$sql = "INSERT INTO scrape_logs(source_id,status,message) values (:id,:status,:message)";
$stmt = $this->db->prepare($sql);

$stmt->bindValue(":id",$id,PDO::PARAM_INT);
$stmt->bindValue(":message",$message,PDO::PARAM_STR);
$stmt->bindValue(":status",$status,PDO::PARAM_STR);
$stmt->execute();

}

}