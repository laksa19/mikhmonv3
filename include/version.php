<?php
if (!isset($_SESSION["mikhmon"])) {
    header("Location:../admin.php?id=login");
  } else {
        $_SESSION["v"] = "3.14 05-09-2019";
        //echo '<span style="display:none" id="ver">314</span>';
    
    }