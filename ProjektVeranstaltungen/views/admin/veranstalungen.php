<?php 

require_once __DIR__."/layout/header.php";
require_once __DIR__."/layout/sidebare.php";
?>

 <div class="col-md-9 col-lg-10 p-2">

 <h1 class=" text-center mb-5 display-2"> Veranstaltungen</h1>
<table class="table ">
    <thead class="table-dark">
        <th scope="col">Id</th>
        <th scope="col">date</th>
        <th scope="col">place</th>
        <th scope="col">start_time</th>
        <th scope="col">end_time</th>
        <th scope="col">booking_link</th>
        <th scope="col">title</th>
        <th scope="col">Löschen</th>
        <th scope="col">edit</th>
</thead>
<tbody>
        <?php 
          foreach ($events["events"] as $event)
        {   echo '<tr id ="event-'.$event["ID_event"].'">';
                echo "<td>" . $event["ID_event"]."</td>";
                echo "<td>" . $event["date"]."</td>";
                echo "<td>" . $event["place"]."</td>";
                echo "<td>" . $event["start_time"]."</td>";
                echo "<td>" . $event["end_time"]."</td>";
                echo "<td>" . $event["booking_link"]."</td>";
                echo "<td>" . $event["title"]."</td>";
                echo '<td > <button data-id="'.htmlspecialchars($event["ID_event"]).'" onclick="Löschen_Event(this)"> Dellte</button></td>';
                echo '<td ><button> edit</button></td>';
            echo "</tr>";
        }
        
        ?>
    </tbody>
    </table>
 


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




    
</nav>
</div>
</div>



<script src="/ProjektVeranstaltungen/views/admin/admin.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

