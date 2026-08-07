<?php

//PHP Controll module
require_once __DIR__ . "/../../Helpers/weekday.php";
require_once __DIR__ . '/../../Controler/event_controler.php';

$controler_event = new EventControler();
$alles = $controler_event->showAll();

//Html module
require  __DIR__ . '/../Layout/header.php';

require  __DIR__ . '/../Layout/head.php';
?>


<?php

foreach ($alles as $event )
{

echo "<div class=\"card mb-3 mt-2\">
    <div class=\"row g-0\">

        <!-- Datum -->
        <div class=\"col-md-2 text-center border-end\">";

        echo "<h3>".$event["date"]."</h1>";
        echo "<p>". helperFunctionWeekday::weekdayConverter($event["date"]) ."</p\">";

        echo"</div>

        <!-- Inhalt -->
        <div class=\"col-md-10\">
            hallo
        </div>

    </div>
</div>
";
}

//echo  "<pre>";
//print_r($alles);
//echo "</pre>";

?>


<?php

require __DIR__.'/../Layout/footer.php';

//Javascript module
require __DIR__.'/../Layout/scripts.php';