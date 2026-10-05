<?php
require_once "Database.php";

$passwort ="timo21!s2";

$hash = password_hash($passwort,PASSWORD_DEFAULT);



$dbt = new Database();
$db = $dbt->getConnection();

$sql ="INSERT INTO admin(Admin_Name,Passwort) Values ('Admin',:hash)";

$stmt = $db->prepare($sql);

$stmt->bindValue(":hash",$hash,PDO::PARAM_STR);

$stmt->execute();

echo "hatt geklappt";