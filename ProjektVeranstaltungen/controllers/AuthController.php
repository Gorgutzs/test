<?php 
// Controler der für die Anmeldung zuständig ist

//Die Eingebunden Dateien
require_once __DIR__ . "/../models/Admin.php";
require_once __DIR__ . "/../config/Database.php";

class AuthController
{
//Properties
private $adminDB;
private $database; 

    public  function  __construct()
    {
        $this->database = new Database();
        $this->adminDB = new Admin ($this->database->getConnection()); 

    }

    //Weiterleitung zur Login seite
    public function index()
    {
     

        require_once __DIR__ . "/../views/auth/login.php";
 
    }

    // Überürfung ob die eigeben Datenrichting sind
    public function login()
    {
        $password = $_POST["Password"] ?? "";
        $username = $_POST["Username"] ?? "";

        $admin = $this->adminDB->getAdminByUsername($username);

        //Passwort und Username wird geprüft. password_verify prüft ob der hash stimmt  
       if ($admin && password_verify($password, $admin["Passwort"]))
         { 
            session_regenerate_id(true);
            $_SESSION["logged"] = true;
            $_SESSION["csrf_token"] = bin2hex(random_bytes(32));                
         }
        header("Location: /ProjektVeranstaltungen/admin");exit();
    }


public static function eingelogged()
{
     if(!isset($_SESSION["logged"]) || $_SESSION["logged"] != true)
        {
            header("Location: /ProjektVeranstaltungen/auth");exit();  
        }
}



public function csrfToken()
{
    if (!isset($_SESSION["logged"]) || $_SESSION["logged"] !== true) {
        http_response_code(401);
        exit();
    }

    echo json_encode([
        "csrf_token" => $_SESSION["csrf_token"]
    ]);
}




}