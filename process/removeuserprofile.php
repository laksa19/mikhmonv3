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

$pid = $removeuserprofile;
$pname = $_GET['pname'];

$getmonid = $API->comm("/system/scheduler/print", array(
    "?name" => "$pname",
));
$monid = $getmonid[0]['.id'];

$API->comm("/ip/hotspot/user/profile/remove", array(
    ".id" => "$pid",
));
$API->comm("/system/scheduler/remove", array(
    ".id" => "$monid",
));
echo "<script>window.location='./?hotspot=user-profiles&session=" . $session . "'</script>";
?>