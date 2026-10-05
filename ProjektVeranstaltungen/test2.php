<?php

require_once __DIR__ . "/models/Events.php";

require_once __DIR__."/config/Database.php";

        $db = new Database();
             $test = new Events($db->getConnection());
            $test2=$test->deleteOldEvents();
            echo $test2;