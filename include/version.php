<?php
if (!isset($_SESSION["mikhmon"])) {
    header("Location:../admin.php?id=login");
  } else {
        $_SESSION["v"] = "3.13 r6 04-01-2019";
        //echo '<span style="display:none" id="ver">3136</span>';
    
    }