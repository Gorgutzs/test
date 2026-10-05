<?php

// Die Route Datei. Hier wird gesteuert wo,wer und wie man zu den einzahlen Seiten kommt und welche Funktion aufgerufen werden.

//Einbundung der Controller
require_once __DIR__ . "/../controllers/EventController.php";
require_once __DIR__ . "/../controllers/ErrorController.php";
require_once __DIR__ . "/../controllers/AdminController.php";
require_once __DIR__ . "/../controllers/AuthController.php";
require_once __DIR__ . "/../controllers/SourceController.php";
require_once __DIR__ ."/../Scraper/HttpClient.php";
require_once __DIR__ ."/../Scraper/Parser.php";
require_once __DIR__ ."/../Scraper/Scraper.php";
require_once __DIR__ . "/../helpers/CSRF.php";



class Routes
{

// Die Einzig funktion in Route. Sie wird von Index aufgerufen damit endschieden wird welche funktion und welche datei aufg
public function run ()
{

    // Dir URL wird von Https und dann ander kruppzeugt befreit und rein gespeichert in $url
    $url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

    // Der Basispfad aka der ober datei ordner
    $basePath = "/ProjektVeranstaltungen";

    //Hier wird der basisdateipfad von $url entfernt danach die slashes um zum schluss wird alles verkleinert
    $url = str_replace($basePath,"",$url);
    $url = trim($url,"/");
    $url = strtolower($url);

    //CSFR Token wird geprüft
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION["logged"])) {Csrf::check();}

    //Endscheidung was mit der URL passiert

    switch($url)
    {

        //Hauptseite von User wird aufgerufen

        case"":
            $controller = new EventController();
            $controller->index();
            break;

        //Fehler der von eine User gemeldet wird in die Datenbank gespeichert

       case "error":      
            $controller = new ErrorController();
            $controller->createErrorMessage();
            break;

        //Falls man Angemeldet ist wird man zur Admin seite geroutet.Wenn man nicht angemelt ist wird man stadesen zur Login seite geroutet 

        case "admin":
                AuthController::eingelogged();
                $controller = new AdminController();
                $controller->error_site();
                break;

        //Man wir falls noch nicht Angemledet ist zur login seite geroutet. Falls man schon angemldet ist wird man stattdesen zum Admindashbord geroutet

        case "auth":
            if(isset($_SESSION["logged"]) && $_SESSION["logged"] === true) {header("Location: /ProjektVeranstaltungen/admin");exit();}
            $controller = new AuthController();
            $controller->index();
            break;

        //Hier wird geprüft ob die eingegeben daten zum Anmelden stimmen. Falls man schon angemledet wird man zum Admindashbord geroutet 

        case "auth/login":
            //Wir Geprüft ob man eingelogt ist falls nicht wird man zur anmeldung zurück gebounce
         
                $controller = new AuthController();
                $controller->login();
                break;
        
        case "auth/csrf":
                
                $controller = new AuthController();
                $controller->csrfToken();
                break;


        case "admin-events":
            //Wir Geprüft ob man eingelogt ist falls nicht wird man zur anmeldung zurück gebounce
            AuthController::eingelogged();
            $controller = new EventController();
            $controller->AdminEvents();
            break;        
        
        //löschen von einzahlen events
        case "events/delete":

                 AuthController::eingelogged();
                 $controller = new EventController();
                 $controller->DeletetEvent();
                 break;


        case "admin/sources":

            AuthController::eingelogged();
            $controller = new SourceController();
            $controller->index();
            break;

        case "sources/delete":

                 AuthController::eingelogged();
                 $controller = new SourceController();
                 $controller->deletetSource();
                 break;
                
        case "sources/aktivieren_deaktivieren":

                AuthController::eingelogged();
                $controller = new SourceController();
                $controller->source_aktivieren_deaktivieren();
                break;

        case "admin/logout":

                AuthController::eingelogged();
                $controller = new AdminController();
                $controller->logout();
                break;

        case "admin/quelle-hinzufuegen":
                
                AuthController::eingelogged();
                $controller = new SourceController();
                $controller->addSource();
                break;
        case "test":

                AuthController::eingelogged();
                $test = new Scraper();
                $id=$_POST["id"];
                $test->ScrapeOne(5);
                break;

        case "test2":

               require_once __DIR__ ."/../boell.php";
                break;


        //Falls der man scheiße in die URL eingibt bekommt man diese nachricht
         default:
            echo $_SERVER["REQUEST_URI"];
            echo http_response_code(404);
            echo " Seite nicht gefunden";
            break;

    }
 

} 

}

