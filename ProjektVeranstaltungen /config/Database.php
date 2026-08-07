<?php

//Klasse um sich mit der DB zu connecten
class Database
{
    private PDO $connection;

    public function __construct()
    {

        $config = require 'database_config.php';

        $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['database']};charset={$config['charset']}";

        //Versuch die verbindung auf zu bauen
        try
        {
        $this->connection = new PDO(
        $dsn,
        $config['username'],
        $config['password']
        );

        $this->connection->setAttribute(
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION
            );

          
            
        } catch(PDOException $e){
            die("Datenbankfehler: " . $e->getMessage()); 
        }
    }

    public function getConnection(): PDO
    { return $this->connection;}

}