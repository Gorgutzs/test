<?php

class HttpClient
{

 private array $noRetryCodes = [
    400,
    401,
    403,
    404,
    405,
    406,
    407,
    410,
    411,
    412,
    413,
    414,
    415,
    416,
    417,
    422,
    423,
    424,
    426,
    428,
    431,
    451
];

    public function get(string $url, int $sleep =2)
    {
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        $status = [ "html"=>null,
                    "http-error"=>null,
                    "curl-error"=>null];

        for ($versuch = 1; $versuch <= 3; $versuch++) {
            
            $html = curl_exec($ch);

            // cURL-/Verbindungsfehler
            if ($html === false) {

                if ($versuch == 3) {
                    $error = curl_error($ch);
                    curl_close($ch);
                    $status["curl-error"]=$error;
                    return $status;
                }
                sleep($sleep);
                continue;
            }

            // HTTP-Status prüfen
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            // HTTP-Fehler
            if ($httpCode >= 400 && $httpCode < 600) {

                if ($versuch == 3) {
                    curl_close($ch);
                    $status["http-error"]=$httpCode;
                    return $status;

                }

                if(in_array($httpCode,$this->noRetryCodes))
                    {
                        curl_close($ch);
                        $status["http-error"]=$httpCode;
                        return $status;
                    }
                sleep($sleep);
                continue;
            }

            // Erfolgreich
            curl_close($ch);

           $status["html"]=$html;
            return $status;
        }
        curl_close($ch);
        return   $status["html"]=$html;
    }
}