<?php


Class Source
{

private $db;

 public function __construct($db)
 {
    $this->db =$db;
 }


 public function getSources($limit,$offset)
 {

    $sql = "SELECT * FROM source LIMIT :limit OFFSET :offset";

    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(":limit",$limit,PDO::PARAM_INT);
    $stmt->bindValue(":offset",$offset, PDO::PARAM_INT);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);

 }





//Gib die Anzahl aller Events raus
public function getSourcesCount()
{

    $sql = "SELECT COUNT(*) FROM source";

    $stmt = $this->db->prepare($sql);
    $stmt->execute();

    return $stmt->fetchColumn();

}




public function delete($id)
{
    $sql = "DELETE FROM source WHERE ID_source = :id;";
    $stmt = $this->db->prepare($sql);

    $stmt->bindValue(":id",$id,PDO::PARAM_INT);
    $stmt->execute();

}

public function aktivieren_deaktivieren($id)
{
    $sql = "UPDATE source 
            SET active = NOT active 
            WHERE ID_source = :id";

    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(":id", $id, PDO::PARAM_INT);

    return $stmt->execute();
}


public function addSource($URL,$Name,$Rule,$Aktivieren)
{

$sql = "INSERT INTO source (url,name,scraper_rule,active) values(:URL,:NAME,:Rule,:Aktivieren)";

$stmt = $this->db->prepare($sql);

$stmt->bindValue(":URL",$URL,PDO::PARAM_STR);
$stmt->bindValue(":NAME",$Name,PDO::PARAM_STR);
$stmt->bindValue(":Rule",$Rule,PDO::PARAM_LOB);
$stmt->bindValue(":Aktivieren",$Aktivieren,PDO::PARAM_BOOL);
$stmt->execute();

}


public function getAllUrlsAndRules()
{
    $sql = "SELECT url, scraper_rule FROM source WHERE active = 1;";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


public function getUrlandRule($id)
{
    $sql = "SELECT url, scraper_rule FROM source WHERE ID_source = :id;";
    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(":id",$id,PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

public function getIDbyURL($url)
{

$sql= "SELECT ID_source FROM source WHERE url = :url";

$stmt =$this->db->prepare($sql);

$stmt->bindValue(":url",$url,PDO::PARAM_STR);
$stmt->execute();
return $stmt->fetchColumn();
}






}