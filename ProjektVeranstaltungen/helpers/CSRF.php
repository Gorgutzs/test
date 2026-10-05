<?php 


class  Csrf
{

public static function check()
    {
        if(isset($_POST["X-CSRF-Token"]))
            {$csrfToken = $_POST["X-CSRF-Token"] ?? "";}
        else
            {$csrfToken = $_SERVER["HTTP_X_CSRF_TOKEN"] ?? "";}

        if (
            !isset($_SESSION["csrf_token"]) ||
            !hash_equals($_SESSION["csrf_token"], $csrfToken)
        ) {
            http_response_code(403);
            echo json_encode([
                "message" => "Ungültiger CSRF-Token"
            ]);
            exit;
        }



    }
}