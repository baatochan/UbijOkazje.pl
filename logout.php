<?php
/**
 * Created by PhpStorm.
 * User: barto
 * Date: 21.01.18
 * Time: 23:18
 */

session_start();
session_destroy();
echo '
        <script type="text/javascript">
           window.location = "index.php?logout"
        </script>
    ';
die();