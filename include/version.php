<?php
if (!isset($_SESSION["mikhmon"])) {
    header("Location:../admin.php?id=login");
  } else {
        $_SESSION["v"] = "3.18 08-16-2019";
    
    }
