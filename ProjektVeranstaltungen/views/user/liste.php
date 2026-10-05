<?php

//Hauptseite zum ansehen der Listen 

//PHP Controll module
require_once __DIR__ . "/../../helpers/TimeHelpers.php";
require_once __DIR__ . '/../../controllers/EventController.php';



//Html module
require  __DIR__ . '/layout/header.php';

require  __DIR__ . '/layout/head.php';

require __DIR__ . '/layout/navbar.php';

require __DIR__ . '/layout/fehlermeldung.php'
?>

<div class="container bg-white my-0 pt-5 pb-5  flex-grow-1">
    
<?php
//Temporte varibeln Zur Erstellung eines neuer Monats/Jahres strichs
$tmpmonth="";
$tmpyear="";
// Die Events werden als carde erstellt
foreach ($events["events"] as $event )
{
// Zur Erstellung eines neuer Monats/Jahres strichs 
if($tmpmonth!=helperFunctionTime::monthConverter($event["date"]) or $tmpyear!=helperFunctionTime::onlyYear($event["date"]))
    {
        $tmpmonth=helperFunctionTime::monthConverter($event["date"]);
        $tmpyear=helperFunctionTime::onlyYear($event["date"]);
        echo '<div > <h6 id="Unterstrich"> '.$tmpmonth." ".$tmpyear."</h6> </div>"; 
    
    }

echo "<div class=\"card mb-4  pb-4 pt-2 border-bottom-0 border-top-0 border-start-0 border-end-0\">
    <div class=\"row g-0\">

        <!-- Datum -->
        <div class=\"col-md-2 text-center border-end-0\">";
        
        echo "<h6>". helperFunctionTime::shortWeekdayConverter($event["date"]) ."</p\">";
        echo "<h4>".helperFunctionTime::onlyDay($event["date"])."</h1>".
        "</div>

        <!-- Inhalt -->
        <div class=\"col-md-10\">
        
        <p>".helperFunctionTime::datum($event["date"])." | ". helperfunctionTime::secondDelter($event["start_time"]);
        if($event["end_time"]!=null) echo " - ".helperfunctionTime::secondDelter($event["end_time"])."</p>";
            echo"<h4> <a href=\" ". $event["booking_link"]. " \">".$event["title"] . "</a></h4>
            <h6>".$event["place"] ."</h5>
        </div>

    </div>
</div>
";

}

?>

</div>
<nav aria-label="Event Pagination">
    <ul class="pagination justify-content-center mt-3">

    <?php 
        // Die Pagnation wird hier erstellt
        if ($events["page"] > 1): ?>

            <li class="page-item">
                <a class="page-link" href="<?= !empty($search) ? "?Search=".$search."&page=".($events["page"] - 1) :"?page=".($events["page"] - 1)?>" >Zurück</a>
            </li>
      <?php endif; ?>
    
    <?php for ($i = 1; $i <= $events["totalPages"]; $i++): ?>
        <li class="page-item <?= $i == $events["page"] ? 'active' : '' ?>">
            <a class="page-link" href="<?= !empty($search)? "?Search=".$search."&page=".$i :"?page=".$i ?>">  <?= $i ?></a>
        </li>
    <?php endfor; ?>
        
         <?php if ($events["page"] < $events["totalPages"]): ?>
            <li class="page-item">
                <a class="page-link" href="<?=!empty($search) ? "?Search=".$search."&page=".($events["page"] + 1) :"?page=".($events["page"] + 1)?>"> Weiter </a>
            </li>

        <?php endif; ?>


    </ul>
</nav>
<?php
//Footer wird eingefügt
require __DIR__.'/layout/footer.php';
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
<script src="/ProjektVeranstaltungen/views/user/layout/user.js"></script>
</body>

</html>

