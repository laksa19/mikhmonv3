<?php
if (!isset($_SESSION["mikhmon"])) {
    header("Location:../admin.php?id=login");
  } else {
        $_SESSION["v"] = "3.13 r3";
        //echo '<span style="display:none" id="ver">3133</span>';
    
    }