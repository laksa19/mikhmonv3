<?php
/*
 *  Copyright (C) 2018 Laksamadi Guko.
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
session_start();
// hide all error
error_reporting(0);
$getuser = $API->comm("/ip/hotspot/user/print", array(
  "?limit-uptime" => "1s",
));
$TotalReg = count($getuser);

$_SESSION['ubp'] = $getuser[0]['profile'];
$_SESSION['ubc'] = "";

for ($i = 0; $i < $TotalReg; $i++) {
  $userdetails = $getuser[$i];
  $uid = $userdetails['.id'];

  $API->comm("/ip/hotspot/user/remove", array(
    ".id" => "$uid",
  ));
}
if ($_SESSION['ubp'] != "") {
  echo "<script>window.location='./?hotspot=users&profile=" . $_SESSION['ubp'] . "&session=" . $session . "'</script>";
} else {
  echo "<script>window.location='./?hotspot=users&profile=all&session=" . $session . "'</script>";
}

?>