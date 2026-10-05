<?php

class Events {

//Die Datenbank verbindung
private $db;

public function __construct($db)
{

    $this->db = $db;

}



//Gibt alle Events aus
public function getEvents($limit,$offset)
{

    $sql = "SELECT * FROM event ORDER BY date DESC LIMIT :limit OFFSET :offset";


    $stmt = $this->db->prepare($sql);

    //die werte von $limmit und $offset werde an limit und offset gebunden
    $stmt->bindValue(":limit",$limit,PDO::PARAM_INT);
    $stmt->bindValue(":offset",$offset, PDO::PARAM_INT);

    $stmt->execute();

    //gibt alles als ein Azzoerites array raus
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

//Gibt alle Events mit dem $search Auswahlkriterium raus
public function getSearchEvents($limit,$offset,$search)
{

    $sql = "SELECT *
    FROM event
    WHERE title LIKE :search
       OR place LIKE :search
       OR DATE_FORMAT(date, '%d.%m.%Y') LIKE :search
       OR start_time LIKE :search
       OR end_time LIKE :search
    ORDER BY date DESC
    LIMIT :limit OFFSET :offset";

    $stmt = $this->db->prepare($sql);

    //Werte werden an die jeweiligen stellen gebunden
    $stmt->bindValue(":limit",$limit,PDO::PARAM_INT);
    $stmt->bindValue(":offset",$offset, PDO::PARAM_INT);
    $stmt->bindValue(":search", $search, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

// Gibt die Anzahl von der gesuchten wärte raus
public function getSearchCount($search)
{

$sql = "SELECT COUNT(*)
    FROM event
    WHERE title LIKE :search
       OR place LIKE :search
       OR DATE_FORMAT(date, '%d.%m.%Y') LIKE :search
       OR start_time LIKE :search
       OR end_time LIKE :search";

    $stmt = $this->db->prepare($sql);

    //Werte werden an die jeweiligen stellen gebunden
    $stmt->bindValue(":search", $search, PDO::PARAM_STR);

    $stmt->execute();

    return $stmt->fetchColumn();

}


public function delete($id)
{
    $sql = "DELETE FROM event WHERE ID_event = :id;";
    $stmt = $this->db->prepare($sql);

    $stmt->bindValue(":id",$id,PDO::PARAM_INT);
    $stmt->execute();

}

//Gib die Anzahl aller Events raus
public function getEventCount()
{

    $sql = "SELECT COUNT(*) FROM event";

    $stmt = $this->db->prepare($sql);
    $stmt->execute();

    return $stmt->fetchColumn();

}



public function insert($event,$id)
{

    $sql = "INSERT INTO event (source_id,date,end_date,place,start_time,end_time,booking_link,title) 
    VALUES(:source_id,:date,:end_date,:place,:start_time,:end_time,:booking_link,:title);";

    $stmt = $this->db->prepare($sql);

    $stmt->bindValue(":source_id",$id,PDO::PARAM_INT);
    $stmt->bindValue(":date",$event["start-date"],PDO::PARAM_STR);
    $stmt->bindValue(":end_date",$event["end-date"],PDO::PARAM_STR);
    $stmt->bindValue(":place",$event["place"],PDO::PARAM_STR);
    $stmt->bindValue(":start_time",$event["start-time"],PDO::PARAM_STR);
    $stmt->bindValue(":end_time",$event["end-time"],PDO::PARAM_STR);
    $stmt->bindValue(":booking_link",$event["link"],PDO::PARAM_STR);
    $stmt->bindValue(":title",$event["title"],PDO::PARAM_STR);

    $stmt->execute();
}
  


public function findExistingEvent($event)
{

    $sql = "SELECT ID_event FROM event WHERE title = :title AND date = :date AND booking_link = :booking_link LIMIT 1;";

    $stmt = $this->db->prepare($sql);
  
 $stmt->execute([
            ':title' => $event['title'],
            ':date' => $event['start-date'],
            ':booking_link' => $event['link'],
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
}



public function saveEvents(array $events,int $id)
{
    $counter = 0;
    foreach($events as $event)
        {

            $eventExist =  $this->findExistingEvent($event);

            if($eventExist)
                {
                    continue;
                }
                else
                {
                    $this->insert($event,$id);
                    $counter++;
                }

        }
return $counter;


}

public function deleteOldEvents()
{


    $datum = date("Y-m-d");
    $sql = "Delete From event WHERE date < :datum;";
    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(":datum",$datum,PDO::PARAM_STR);
    $stmt->execute();   
    return "hat gekllapt";


}



}

