<?php

//PHP Controll module
require_once __DIR__ . "/../../Helpers/timeHelpers.php";
require_once __DIR__ . '/../../Controler/event_controler.php';

$controler_event = new EventControler();
$events = $controler_event->getEvents();

//Html module
require  __DIR__ . '/../Layout/header.php';

require  __DIR__ . '/../Layout/head.php';

require __DIR__ . '/../Layout/navbar.php'
?>

<div class="container bg-white my-0 pt-5 pb-5 ">
    
<?php

foreach ($events["events"] as $event )
{

echo "<div class=\"card mb-4  pb-4 pt-2 border-top-0 border-start-0 border-end-0\">
    <div class=\"row g-0\">

        <!-- Datum -->
        <div class=\"col-md-2 text-center border-end-0\">";
        
        echo "<h4>". helperFunctionTime::weekdayConverter($event["date"]) ."</p\">";
        echo "<h5>".$event["date"]."</h1>".
        "</div>

        <!-- Inhalt -->
        <div class=\"col-md-10\">

        <p>".$event["place"]." ". helperfunctionTime::secondDelter($event["start_time"]);
        if($event["end_time"]!=null) echo " - ".helperfunctionTime::secondDelter($event["end_time"])."</p>";
            echo"<h4> <a href=\" ". $event["booking_link"]. " \">".$event["title"] . "</a></h4>
        </div>

    </div>
</div>
";

}


//echo  "<pre>";
//print_r($alles);
//echo "</pre>";

?>

</div>
<nav arial-label="Event Pagination">
    <ul class="pagination justify-content-center mt-3">

    <?php if ($events["page"] > 1): ?>

            <li class="page-item">
                <a class="page-link" href="?page=<?= $events["page"] - 1 ?>">Zurück</a>
            </li>
      <?php endif; ?>
    
    <?php for ($i = 1; $i <= $events["totalPages"]; $i++): ?>
        <li class="page-item <?= $i == $events["page"] ? 'active' : '' ?>">
            <a class="page-link" href="?page=<?= $i ?> "><?= $i ?></a>
        </li>
    <?php endfor; ?>
        
         <?php if ($events["page"] < $events["totalPages"]): ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?= $events["page"] + 1 ?>"> Weiter </a>
            </li>

        <?php endif; ?>


    </ul>
</nav>
<?php

require __DIR__.'/../Layout/footer.php';

//Javascript module
require __DIR__.'/../Layout/scripts.php';