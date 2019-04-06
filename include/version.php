<?php
if (!isset($_SESSION["mikhmon"])) {
    header("Location:../admin.php?id=login");
  } else {
        $_SESSION["v"] = "3.13 r7 04-06-2019";
        //echo '<span style="display:none" id="ver">3137</span>';
    
    }