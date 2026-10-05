<?php



class Admin
{

private  $db;

public function __construct($db)
{
$this->db = $db;
}

// Holt die Daten von Admin viva Eingennamen.
public function getAdminByUsername($username)
{

$sql= "SELECT * FROM admin WHERE Admin_Name = :username";

$stmt = $this->db->prepare($sql);

$stmt->bindValue(":username",$username,PDO::PARAM_STR);

$stmt->execute();

return $stmt->fetch(PDO::FETCH_ASSOC);


}




}