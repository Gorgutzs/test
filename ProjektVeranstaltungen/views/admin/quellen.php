<?php 

require_once __DIR__."/layout/header.php";
require_once __DIR__."/layout/sidebare.php";
require_once __DIR__."/quelle_modal.php";
?>

 <div class="col-md-9 col-lg-10 p-2">

  <h1 class=" text-center mb-5 display-2"> Quellen</h1>
<button class=" mb-1 btn btn-light"  id="Qulle_Hinzufügen">Quelle Hinzufügen</button>
<table class="table ">
    <thead class="table-dark">
        <th scope="col">Id</th>
        <th scope="col">url</th>
        <th scope="col">scraper_rule</th>
        <th scope="col">created_at</th>
        <th scope="col">updated_at</th>
        <th scope="col">name</th>
        <th scope="col">Status</th>
        <th scope="col">last_run</th>
        <th scope="col">löscehn</th>
        <th scope="col">edit</th>
        <th scope="col">Status-Ändern</th>
</thead>
<tbody>
        <?php 
          foreach ($sourceListe["sources"] as $source)
        {   echo '<tr id ="event-'.$source["ID_source"].'">';
                echo "<td>" . $source["ID_source"]."</td>";
                echo "<td>" . $source["url"]."</td>";
                echo "<td>" . $source["scraper_rule"]."</td>";
                echo "<td>" . $source["created_at"]."</td>";
                echo "<td>" . $source["updated_at"]."</td>";
                echo "<td>" . $source["name"]."</td>";
                echo '<td id="active '. $source["ID_source"] .'" class="align-middle" > <span class="rounded-circle ' . ($source["active"] ? "bg-success" : "bg-danger") . ' d-block mx-auto" style="width: 15px; height: 15px;"> </span></td>';
                echo "<td>" . $source["last_run"]."</td>";
                echo '<td > <button data-id="'.$source["ID_source"].'" onclick="Löschen_Source(this)"> Dellte</button></td>';
                echo '<td ><button> edit</button></td>';
                echo '<td><button data-id="'.$source["ID_source"].'" onclick="Source_aktivieren_deaktivieren(this) ">'.  ($source["active"] ? "Deaktivieren" : "Aktivieren").'</button></td>';
            echo "</tr>";
        }
        
        ?>
    </tbody>
    </table>
 

<nav aria-label="Event Pagination">
    <ul class="pagination justify-content-center mt-3">

    <?php 
        // Die Pagnation wird hier erstellt
        if ($sourceListe["page"] > 1): ?>

            <li class="page-item">
                <a class="page-link" href="<?= !empty($search) ? "?Search=".$search."&page=".($sourceListe["page"] - 1) :"?page=".($sourceListe["page"] - 1)?>" >Zurück</a>
            </li>
      <?php endif; ?>
    
    <?php for ($i = 1; $i <= $sourceListe["totalPages"]; $i++): ?>
        <li class="page-item <?= $i == $sourceListe["page"] ? 'active' : '' ?>">
            <a class="page-link" href="<?= !empty($search)? "?Search=".$search."&page=".$i :"?page=".$i ?>">  <?= $i ?></a>
        </li>
    <?php endfor; ?>
        
         <?php if ($sourceListe["page"] < $sourceListe["totalPages"]): ?>
            <li class="page-item">
                <a class="page-link" href="<?=!empty($search) ? "?Search=".$search."&page=".($sources["page"] + 1) :"?page=".($sources["page"] + 1)?>"> Weiter </a>
            </li>

        <?php endif; ?>


    </ul>
</nav>




    
</nav>
</div>
</div>



<script src="/js/admin.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>