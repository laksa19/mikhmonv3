<?php
if (!isset($_SESSION["mikhmon"])) {
    header("Location:../admin.php?id=login");
  } else {
        $_SESSION["v"] = "3.15 07-02-2019";
        //echo '<span style="display:none" id="ver">315</span>';
    
    }
